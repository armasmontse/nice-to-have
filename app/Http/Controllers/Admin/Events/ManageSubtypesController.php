<?php

namespace App\Http\Controllers\Admin\Events;

use App\Http\Requests\Admin\Events\Subtype\CreateSubtypeRequest;
use App\Http\Requests\Admin\Events\Subtype\UpdateSubtypeRequest;
use App\Http\Requests;
use App\Http\Controllers\Controller;
use App\Models\Events\Subtype;
use App\Models\Events\Type;

use Response;

class ManageSubtypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Subtype::with("languages", "type", "type.languages")
            ->join('types', 'types.id', '=', 'subtypes.type_id')
            ->orderBy("type_order")
            ->orderBy("order")
            ->GetWithTranslations([
                'types.order as type_order'
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
        return view('admin.events.types.subtypes.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSubtypeRequest $request)
    {

        $input = $request->all();

        $subtype = Subtype::create([
            "type_id"   => $input["type_id"],
            "order"     => $input["order"],
        ]);

        $subtype->type_id = $input["type_id"];

        if (!$subtype->save()) {
            return Response::json([
                'error' => ["El subtipo de evento no pudo ser creado"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $name = $input["label"][$language->iso6391];
            $subtype->updateTranslationByIso($language->iso6391,[
                'label'         => $name,
                'slug'          => Subtype::generateUniqueSlug($name),
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'=> Subtype::with("languages")
                ->join('types', 'types.id', '=', 'subtypes.type_id')
                ->GetWithTranslations([
                    'types.order as type_order'
                ])
                ->find($subtype->id),
            'message' => ["El subtipo de evento fue creado correctamente"],
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
    public function update(UpdateSubtypeRequest $request, Subtype $subtype)
    {
        $input = $request->all();

        $subtype->type_id = $input["type_id"];
        $subtype->order = $input["order"];

        if (!$subtype->save()) {
            return Response::json([
                'error' => ["El subtipo de evento no pudo ser actualizado"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $name = $input["label"][$language->iso6391];
            $subtype->updateTranslationByIso($language->iso6391,[
                'label'         => $name,
                'slug'          => $subtype->updateUniqueSlug($name,$language->iso6391),
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'      => Subtype::with("languages")->join('types', 'types.id', '=', 'subtypes.type_id')->getWithTranslations(['types.order as type_order'])->find($subtype->id),
            'message'   => ["El subtipo de evento fue correctamente actualizado"],
            'success'   => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Subtype $subtype)
    {
        if (!$subtype->isDeletable()) {
            return Response::json([
                'error' => ["El subtipo de evento que desea borrar tiene elementos asociados"]
            ], 422);
        }

        if (!$subtype->languages()->detach()) {
            return Response::json([
                'error' => ["El subtipo de evento no pudo ser borrado"]
            ], 422);
        }

        if (!$subtype->delete()) {
            return Response::json([
                'error' => ["El subtipo de evento no pudo ser borrado"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'message' => ["El subtipo de evento fue borrao correctamente"],
            'success' => true
        ]);
    }
}
