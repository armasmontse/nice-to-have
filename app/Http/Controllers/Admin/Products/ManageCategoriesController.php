<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;

use App\Http\Requests\Admin\Products\Categories\CreateCategoryRequest;
use App\Http\Requests\Admin\Products\Categories\UpdateCategoryRequest;

use App\Http\Controllers\Controller;

use App\Models\Products\Category;

use Response;

class ManageCategoriesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Category::orderBy("order","asc")->with("languages","subcategories","subcategories.languages")->GetWithTranslations()->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('admin.products.categories.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCategoryRequest $request)
    {
        $input = $request->all();

        $category = Category::create([
            "order" => $input["order"]
        ]);

        if (!$category) {
            return Response::json([
                'error' => ["La categoría no pudo ser creada"]
            ], 422);
        }


        foreach ($this->languages as $language) {
            $name = $input["label"][$language->iso6391];
            $category->updateTranslationByIso($language->iso6391,[
                'label'=> $name,
                'slug' => Category::generateUniqueSlug($name)
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> Category::getWithTranslations()->find($category->id),
            'message' => ["La categoría fue creado correctamente"],
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
    public function update(UpdateCategoryRequest $request,Category $category)
    {
        $input = $request->all();

        $category->order = $input["order"];

        if (!$category->save()) {
            return Response::json([
                'error' => ["La categoría no pudo ser actualizada"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $name = $input["label"][$language->iso6391];
            $category->updateTranslationByIso($language->iso6391,[
                'label' => $name,
                'slug'  => $category->updateUniqueSlug($name,$language->iso6391),
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'      => Category::getWithTranslations()->find($category->id),
            'message'   => ["La categoría fue correctamente actualizada"],
            'success'   => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if (!$category->isDeletable()) {
            return Response::json([
                'error' => ["La categoría que desea borrar tiene elementos asociados"]
            ], 422);
        }

        if (!$category->languages()->detach()) {
            return Response::json([
                'error' => ["La categoría no pudo ser borrada"]
            ], 422);
        }

        if (!$category->delete()) {
            return Response::json([
                'error' => ["La categoría no pudo ser borrada"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'message' => ["La categoría fue borrada correctamente"],
            'success' => true
        ]);
    }
}
