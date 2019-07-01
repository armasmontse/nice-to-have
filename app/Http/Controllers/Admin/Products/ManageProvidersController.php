<?php

namespace App\Http\Controllers\Admin\Products;

use Illuminate\Http\Request;

use App\Http\Requests\Admin\Products\Providers\CreateProviderRequest;
use App\Http\Requests\Admin\Products\Providers\UpdateProviderRequest;
use App\Http\Controllers\Controller;
use App\Http\Requests;

use App\Models\Products\Provider;
use App\Models\Shop\BagStatus;

use Response;

class ManageProvidersController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Provider::orderBy("label","ASC")->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('admin.products.providers.index');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateProviderRequest $request)
    {
        $input = $request->all();

        $name = $input["label"];
        $slug = Provider::generateUniqueSlug($name);
        $provider = Provider::create(

            [
                'sku_suffix' => Provider::generateUniqueSkuSuffixBySlug($slug),
                'slug'       => $slug,
                'label'      => $name
            ]
        );

        if (!$provider) {
            return Response::json([
                'error' => ["El proveedor no pudo ser creado"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> $provider,
            'message' => ["El proveedor fue creado correctamente"],
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
    public function update(UpdateProviderRequest $request, Provider $provider)
    {
        $input = $request->all();

    // el sku suffix no se actualiza para evitar problemas
        $name = $input["label"];
        $provider->label = $name;

        $provider->slug = $provider->updateUniqueSlug($name);;

        if (!$provider->save()) {
            return Response::json([
                'error' => ["La categoría no pudo ser actualizada"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> $provider,
            'message' => ["La categoría fue correctamente actualizada"],
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Provider $provider)
    {
        if (!$provider->isDeletable()) {
            return Response::json([
                'error' => ["El proveedor que desea borrar tiene productos asociados"]
            ], 422);
        }

        if (!$provider->delete()) {
            return Response::json([
                'error' => ["El proveedor no pudo ser borrado"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'message' => ["El proveedor fue borrado correctamente"],
            'success' => true
        ]);
    }

    /**
    * Display products belongs to the provider
    *
    * @return \Illuminate\Http\Response
    **/
    public function show(Provider $provider)
    {
        $data = [
            'provider'      => $provider,
            'products'      => $provider->products_skus_bags(),
            'bags_status'   => BagStatus::where('paid', true)->get()
        ];

        return view('admin.products.providers._show', $data);
    }
}
