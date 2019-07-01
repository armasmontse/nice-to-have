<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Products\CreateProductRequest;
use App\Http\Requests\Admin\Products\UpdateProductRequest;

use App\Models\Products\Product;
use App\Models\Products\Provider;

use App\Publish;

use Redirect;


class ManageProductsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Product::orderedBy('title')->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
    //Regreso a la vista de index la informacion de los productos
        $data = [
            "products" => Product::with("publish","languages","provider","subcategories.languages", "subtypes.languages")->orderedBy('title')->get()
        ];
        return view('admin.products.index', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $data = [
            "product_edit"     => new Product,
            "publiches_list"   => Publish::get()->pluck("label","id")
        ];

        return view('admin.products.create',$data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductRequest $request)
    {
        $input = $request->all();

        $provider = Provider::find($input["provider_id"]);

        $product = Product::create([
            "code"          => Product::generateUniqueCode(implode(" ", $input["title"]) , $provider->sku_suffix ),
            "provider_id"   => $provider->id,
			'publish_id'	=> $input["publish_id"],
			'publish_at'	=> $input["publish_date"],
        ]);

        if (!$product) {
            return Redirect::back()->withErrors(["El producto no pudo ser creado"]);
        }

        foreach ($this->languages as $language) {
            $product->updateTranslationByIso($language->iso6391,[
                'title'         => $input["title"][$language->iso6391],
                'description'   => $input["description"][$language->iso6391],
                'slug'          => Product::generateUniqueSlug($input["title"][$language->iso6391])
            ]);
        }

        updateMYSQLTimestamp();

        return Redirect::route('admin::products.edit',$product->id)->with('status', "El producto fue correctamente creado");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show(Product $product_editable)
    {
        return $product_editable;
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Product $product_editable)
    {
        $data = [
            "product_edit"     => $product_editable,
            "publiches_list"   => Publish::get()->pluck("label","id"),
            "photos_order"     => [
                [
                    "class" => "col-xs-4",
                    "order" => 0
                ],
                [
                    "class" => "col-xs-4",
                    "order" => 1
                ],
                [
                    "class" => "col-xs-4",
                    "order" => 2
                ],

                [
                    "class" => "col-xs-9",
                    "order" => 3
                ],
                [
                    "class" => "col-xs-3",
                    "order" => 4
                ],
            ]
        ];
        return view('admin.products.edit',$data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductRequest $request, Product $product_editable)
    {
        $input = $request->all();

        $product_editable->provider_id = $input["provider_id"];
		$product_editable->publish_id	= $input["publish_id"];
		$product_editable->publish_at	= $input["publish_date"];

        if (!$product_editable->save()) {
            return Redirect::back()->withErrors(["El producto no pudo ser actualizado"]);
        }

        foreach ($this->languages as $language) {
            $product_editable->updateTranslationByIso($language->iso6391,[
                'title'         => $input["title"][$language->iso6391],
                'description'   => $input["description"][$language->iso6391],
                'slug'          => $product_editable->updateUniqueSlug($input["title"][$language->iso6391],$language->iso6391),
            ]);
        }

        updateMYSQLTimestamp();

        return Redirect::route('admin::products.edit',$product_editable->id)->with('status', "El producto fue correctamente actualizado");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $erasable_product)
    {
        if (!$erasable_product->delete()) {
            return Redirect::back()->withErrors(["El producto no pudo ser borrado"]); //Enviar el mensaje con el idioma que corresponde
        }

        updateMYSQLTimestamp();

        return Redirect::route('admin::products.trash')->with('status', "El producto fue correctamente borrado");
    }

    public function trash()
    {
        $data = [
            "products_disabled" => Product::with("publish","languages","provider","subcategories.languages", "subtypes.languages")->onlyTrashed()->get()
        ];
        return view('admin.products.trash',$data);
    }

    public function recovery(Product $product_trashed)
    {

        if (!$product_trashed->restore()) {
            return Redirect::back()->withErrors(["El producto no pudo ser recuperado"]); //Enviar el mensaje con el idioma que corresponde
        }

        updateMYSQLTimestamp();

        return Redirect::route('admin::products.index')->with('status', "El producto fue correctamente recuperado");
    }

}
