<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Products\UpdateAssociateSubcategoryRequest;
use App\Http\Requests\Admin\Products\UpdateAssociateSubtypeRequest;
use App\Http\Requests\Admin\Products\UpdateAssociateProductRequest;

use App\Models\Products\Product;
use App\Models\Products\Subcategory;

use App\Models\Events\Subtype;
use Response;

class ManageProductRelationsController extends Controller
{
    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function updateSubcategory(UpdateAssociateSubcategoryRequest $request, Product $product_editable,Subcategory $subcategory)
    {
        $input = $request->all();

        // dd($input);
        $is_associated = isset($input["subcategories"]);

        if ($is_associated) {
            if ($product_editable->subcategories()->find($subcategory->id)) {
                return Response::json([
                    'data'=> [
                        "subcategory_id"        =>  $subcategory->id,
                        "is_associated"    =>  true
                    ],
                    'error' => ["La subcategoría que desea asociar ya se encuetra previamente asociada"]
                ], 422);
            }

            if (!$product_editable->subcategories()->save($subcategory)) {
                return Response::json([
                    'data'=> [
                        "subcategory_id"        =>  $subcategory->id,
                        "is_associated"    =>  false
                    ],
                    'error' => ["La subcategoría no pudo ser asociada"]
                ], 422);
            }


            $mesaje = ["Subcategoría asociada correctamente."];
        }else{
            if (!$product_editable->subcategories()->detach($subcategory)) {
                return Response::json([
                    'data'=> [
                        "subcategory_id"        =>  $subcategory->id,
                        "is_associated"    =>  true
                    ],
                    'error' => ["La subcategoría no pudo ser desasociada"]
                ], 422);
            }

            $mesaje = ["Subcategoría desasociada correctamente."];
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> [
                "subcategory_id"        =>  $subcategory->id,
                "is_associated"    => $is_associated
            ],
            'message' => $mesaje,
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
    public function updateSubtype(UpdateAssociateSubtypeRequest $request, Product $product_editable,Subtype $subtype)
    {
        $input = $request->all();

        $is_associated = isset($input["subtypes"]);

        if ($is_associated) {
            if ($product_editable->subtypes()->find($subtype->id)) {
                return Response::json([
                    'data'=> [
                        "subtype_id"        =>  $subtype->id,
                        "is_associated"    =>  true
                    ],
                    'error' => ["El subtipo de evento que desea asociar ya se encuetra previamente asociado"]
                ], 422);
            }

            if (!$product_editable->subtypes()->save($subtype)) {
                return Response::json([
                    'data'=> [
                        "subtype_id"        =>  $subtype->id,
                        "is_associated"    =>  false
                    ],
                    'error' => ["El subtipo de evento no pudo ser asociado"]
                ], 422);
            }


            $mesaje = ["Subtipo asociado correctamente."];
        }else{
            if (!$product_editable->subtypes()->detach($subtype)) {
                return Response::json([
                    'data'=> [
                        "subtype_id"        =>  $subtype->id,
                        "is_associated"    =>  true
                    ],
                    'error' => ["El subtipo de evento no pudo ser desasociado"]
                ], 422);
            }

            $mesaje = ["Subcategoría desasociado correctamente."];
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> [
                "subtype_id"        =>  $subtype->id,
                "is_associated"    => $is_associated
            ],
            'message' => $mesaje,
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
    public function updateProduct(UpdateAssociateProductRequest $request, Product $product_editable)
    {
        $input = $request->all();

        $products_ids  = isset($input["products"]) ? $input["products"] : [];
        // dd($products_ids);

        if (!$product_editable->productsRelated()->sync($products_ids) ) {
            return Response::json([
                'data'=> [
                    "related_products" =>  $product_editable->productsRelated()->get(),
                ],
                'error' => ["Los productos no fueron correctamente relacionados"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> [
                "related_products" =>  $product_editable->productsRelated()->get(),
            ],
            'message' => ["Los productos fueron correctamente relacionados"],
            'success' => true
        ]);

    }

}
