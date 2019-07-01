<?php

namespace App\Http\Controllers\Admin\Skus;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Skus\CreateProductSkuRequest;
use App\Http\Requests\Admin\Skus\UpdateProductSkuRequest;

use App\Models\Products\Product;
use App\Models\Skus\Sku;

use Response;

class ManageSkusController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product_editable)
    {
        return $product_editable->skus()->GetWithTranslations()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProductSkuRequest $request, Product $product_editable)
    {

        $input = $request->all();
        // dd($input);

        $product_sku = Sku::create([
            "sku"                       => Sku::generateUniqueSku($product_editable->code, implode(" ", $input["description"])),
            "price"                     => $input["price"],
            "local_shipping_rate"       => $input["local_shipping_rate"],
            "national_shipping_rate"    => $input["national_shipping_rate"],
            "discount"                  => $input["discount"],
            "default"                   => isset($input["default"]),
            "product_id"                => $product_editable->id
        ]);

        if (!$product_sku) {
            return Response::json([
                'error' => ["El sku no pudo ser creado"]
            ], 422);
        }


        foreach ($this->languages as $language) {
            $product_sku->updateTranslationByIso($language->iso6391,[
                'description'   =>  $input["description"][$language->iso6391],
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> Sku::GetWithTranslations()->with("languages")->find($product_sku->sku),
            'message' => ["El sku fue creado correctamente"],
            'success' => true
        ]);

    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateProductSkuRequest $request, Product $product_editable, Sku $product_sku)
    {
        $input = $request->all();

        $product_sku->price            = $input["price"];
        $product_sku->local_shipping_rate    = $input["local_shipping_rate"];
        $product_sku->national_shipping_rate    = $input["national_shipping_rate"];
        $product_sku->discount         = $input["discount"];
        $product_sku->default          = isset($input["default"]);

        if (!$product_sku->save()) {
            return Response::json([
                'error' => ["El Skus no pudo ser actualizado"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $product_sku->updateTranslationByIso($language->iso6391,[
                'description'   =>  $input["description"][$language->iso6391],
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'      => $product_editable->skus()->GetWithTranslations()->where(["sku" => $product_sku->sku])->first(),
            'message'   => ["El Sku fue correctamente actualizado"],
            'success'   => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy( Product $product_editable, Sku $product_sku)
    {
        // dd($product_editable->id,$product_sku->sku,$product_editable->skus()->where(["sku" => $product_sku->sku])->first());
        if (!$product_sku->isDeletable()) {
            return Response::json([
                'error' => ["El sku que desea borrar tiene elementos asociados"]
            ], 422);
        }

        if (!$product_sku->languages()->detach()) {
            return Response::json([
                'error' => ["El sku no pudo ser borrado"]
            ], 422);
        }

        if ($product_sku->photos->count() > 0 ) {
            if (!$product_sku->photos()->detach()) {
                return Response::json([
                    'error' => ["El sku no pudo ser borrado photos"]
                ], 422);
            }
        }

        if (!$product_sku->delete()) {
            return Response::json([
                'error' => ["El sku no pudo ser borrado"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'message' => ["El sku fue borrado correctamente"],
            'success' => true
        ]);

    }
}
