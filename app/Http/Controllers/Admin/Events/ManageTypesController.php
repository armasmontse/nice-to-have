<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests\Admin\Events\Types\CreateTypeRequest;
use App\Http\Requests\Admin\Events\Types\UpdateTypeRequest;

use App\Http\Controllers\Controller;
use App\Models\Events\Type;

use Response;

class ManageTypesController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Type::with("languages","subtypes","subtypes.languages")->orderBy("order")->GetWithTranslations()->get();
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function indexView()
    {
        return view('admin.events.types.index');
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateTypeRequest $request)
    {
        $input = $request->all();

        $type = Type::create([
            "order" => $input["order"]
        ]);

        if (!$type) {
            return Response::json([
                'error' => ["El tipo de evento no pudo ser creado"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $name = $input["label"][$language->iso6391];
            $type->updateTranslationByIso($language->iso6391,[
                'label'         => $name,
                'slug'          => Type::generateUniqueSlug($name),
                'description'   => $input["description"][$language->iso6391],
                'title'         => $input["title"][$language->iso6391],
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'      => Type::with("languages","subtypes","subtypes.languages")->GetWithTranslations()->find($type->id),
            'message'   => ["El tipo de evento fue creado correctamente"],
            'success'   => true
        ]);

    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTypeRequest $request, Type $type)
    {
        $input = $request->all();

        $type->order = $input["order"];

        if (!$type->save()) {
            return Response::json([
                'error' => ["El tipo de evento no pudo ser actualizado"]
            ], 422);
        }

        foreach ($this->languages as $language) {
            $name = $input["label"][$language->iso6391];
            $type->updateTranslationByIso($language->iso6391,[
                'label'         => $name,
                'slug'          => $type->updateUniqueSlug($name,$language->iso6391),
                'description'   => $input["description"][$language->iso6391],
                'title'         => $input["title"][$language->iso6391],
            ]);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'data'      => Type::with("languages","subtypes","subtypes.languages")->GetWithTranslations()->find($type->id),
            'message'   => ["El tipo de evento fue correctamente actualizado"],
            'success'   => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Type $type)
    {
        if (!$type->isDeletable()) {
            return Response::json([
                'error' => ["El tipo de evento que desea borrar tiene elementos asociados"]
            ], 422);
        }

        if (!$type->languages()->detach()) {
            return Response::json([
                'error' => ["El tipo de evento no pudo ser borrado"]
            ], 422);
        }

        if ($type->photos->count() > 0 ) {
            if (!$type->photos()->detach()) {
                return Response::json([
                    'error' => ["El tipo de evento no pudo ser borrado photos"]
                ], 422);
            }
        }

        if (!$type->delete()) {
            return Response::json([
                'error' => ["El tipo de evento no pudo ser borrado"]
            ], 422);
        }

        updateMYSQLTimestamp();

        return Response::json([ // todo bien
            'message' => ["El tipo de evento fue borrao correctamente"],
            'success' => true
        ]);
    }
}
