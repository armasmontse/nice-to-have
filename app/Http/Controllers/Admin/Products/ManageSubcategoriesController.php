<?php

namespace App\Http\Controllers\Admin\Products;

use App\Http\Requests\Admin\Products\Subcategories\CreateSubcategoryRequest;
use App\Http\Requests\Admin\Products\Subcategories\UpdateSubcategoryRequest;

use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Products\Subcategory;
use App\Models\Products\Category;

use Response;

class ManageSubcategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Subcategory::with("languages", "category", "category.languages")
            ->orderBy("category_order")
            ->orderBy("order")
            ->join('categories', 'categories.id', '=', 'subcategories.category_id')
            ->GetWithTranslations([
                'categories.order as category_order'
            ])
            ->get();
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('admin.products.categories.subcategories.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSubcategoryRequest $request)
    {
        $input = $request->all();

        $subcategory = Subcategory::create([
            "category_id" =>  $input["category_id"],
            "order"         =>  $input["order"],
        ]);

        $subcategory->category_id = $input["category_id"];

        if (!$subcategory->save()) {
            return Response::json([
                'error' => ["La subcategoría no pudo ser creada"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $name = $input["label"][$language->iso6391];
            $subcategory->updateTranslationByIso($language->iso6391,[
                'label'         => $name,
                'slug'          => Subcategory::generateUniqueSlug($name),
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> Subcategory::join('categories', 'categories.id', '=', 'subcategories.category_id')
                ->GetWithTranslations([
                    'categories.order as category_order'
                ])
                ->find($subcategory->id),
            'message' => ["La subcategoría fue creada correctamente"],
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
    public function update(UpdateSubcategoryRequest $request, Subcategory $subcategory)
    {
        $input = $request->all();

        $subcategory->category_id = $input["category_id"];
        $subcategory->order       =  $input["order"];

        if (!$subcategory->save()) {
            return Response::json([
                'error' => ["La subcategoría no pudo ser actualizada"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $name = $input["label"][$language->iso6391];
            $subcategory->updateTranslationByIso($language->iso6391,[
                'label'         => $name,
                'slug'          => $subcategory->updateUniqueSlug($name,$language->iso6391),
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'      => Subcategory::join('categories', 'categories.id', '=', 'subcategories.category_id')->getWithTranslations(['categories.order as category_order'])->find($subcategory->id),
            'message'   => ["La subcategoría fue correctamente actualizada"],
            'success'   => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subcategory $subcategory)
    {
        if (!$subcategory->isDeletable()) {
            return Response::json([
                'error' => ["La subcategoría que desea borrar tiene elementos asociados"]
            ], 422);
        }

        if (!$subcategory->languages()->detach()) {
            return Response::json([
                'error' => ["La subcategoría no pudo ser borrada"]
            ], 422);
        }

        if (!$subcategory->delete()) {
            return Response::json([
                'error' => ["La subcategoría no pudo ser borrada"]
            ], 422);
        }
        
        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'message' => ["La subcategoría fue borrada correctamente"],
            'success' => true
        ]);
    }
}
