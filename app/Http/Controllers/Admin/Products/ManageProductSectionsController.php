<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Products\Sections\CreateSectionRequest;
use App\Http\Requests\Admin\Products\Sections\UpdateSectionRequest;

use App\Models\Products\Product;
use App\Models\Products\ProductSection;

use Response;

class ManageProductSectionsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Product $product_editable)
    {
        return $product_editable->productSections()->GetWithTranslations()->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSectionRequest $request,Product $product_editable)
    {
        $input = $request->all();

        $product_section = ProductSection::create([
            "order"         => $input["order"],
            "product_id"    => $product_editable->id
        ]);

        if (!$product_section) {
            return Response::json([
                'error' => ["La seccion no pudo ser creada"]
            ], 422);
        }


        foreach ($this->languages as $language) {
            $product_section->updateTranslationByIso($language->iso6391,[
                'title'   =>  $input["title"][$language->iso6391],
                'content' => $input["content"][$language->iso6391]
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> ProductSection::GetWithTranslations()->with("languages")->find($product_section->id),
            'message' => ["La seccion fue creado correctamente"],
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
    public function update(UpdateSectionRequest $request, Product $product_editable,  ProductSection $product_section)
    {

        $input = $request->all();

        $product_section->order       =  $input["order"];

        if (!$product_section->save()) {
            return Response::json([
                'error' => ["La seccion no pudo ser actualizada"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $product_section->updateTranslationByIso($language->iso6391,[
                'title'   =>  $input["title"][$language->iso6391],
                'content' => $input["content"][$language->iso6391]
            ]);
        }


        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> ProductSection::GetWithTranslations()->with("languages")->find($product_section->id),
            'message' => ["La seccion fue correctamente actualizada"],
            'success' => true
        ]);

    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Product $product_editable, ProductSection $product_section)
    {
        if (!$product_section->languages()->detach()) {
            return Response::json([
                'error' => ["La seccion no pudo ser borrada"]
            ], 422);
        }

        if (!$product_section->delete()) {
            return Response::json([
                'error' => ["La seccion no pudo ser borrada"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'message' => ["La seccion fue borrada correctamente"],
            'success' => true
        ]);
    }
}
