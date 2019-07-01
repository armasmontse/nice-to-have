<?php

namespace App\Http\Controllers\Users\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Http\Requests\Users\Events\Templates\UpdateTemplateEventRequest;
use App\Http\Requests\Users\Events\Templates\UpdateTemplateHeaderRequest;
use App\Http\Requests\Users\Events\Templates\CreatePhotoRequest;

use App\User;
use App\Models\Events\Event;
use App\Models\Events\ColorPalette;
use App\Models\Events\EventTemplate;
use App\Models\Events\EventTemplateHeader;
use App\Models\Events\EventTemplateSectionType;

use App\Photo;

use Response;
use Redirect;

class TemplateEventController extends ClientController
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Event $personal_event)
    {
		if (!$personal_event->eventTemplate) {
			$personal_event->eventTemplate()->create([]);
		}

		$data = [
			'personal_event'	=> $personal_event->load([
				'eventTemplate',
				'eventTemplate.eventTemplateSections' => function($query){
					$query->orderBy('order');
				},
				'eventTemplate.eventTemplateSections.eventTemplateSectionType',
			]),
			'color_palettes'	=> ColorPalette::all(),
			'template_headers'	=> EventTemplateHeader::all(),
			'section_types'		=> EventTemplateSectionType::all(),
		];

		return view('users.events.templates.index', $data);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateTemplateEventRequest $request, User $user, Event $personal_event)
    {
		if (!$personal_event->eventStatus->active) {
			return Response::json([
                'error' => ["Unauthorized"]
            ], 422);
		}

		$input = $request->all();

		$personal_event->eventTemplate->color_palette_id = $input['palette'];
        $personal_event->eventTemplate->event_template_header_id = $input['template'];

        if(!$personal_event->eventTemplate->save())
        {
			return Response::json([
                'error' => ["No se pudo guardar diseño y paleta de colores"]
            ], 422);
        }

		return Response::json([
            'data'      => $personal_event->load([
				'eventTemplate',
				'eventTemplate.eventTemplateSections' => function($query){
					$query->orderBy('order');
				},
				'eventTemplate.eventTemplateSections.eventTemplateSectionType',
			]),
            'message'   => ['Diseño y paleta de colores correctamente actualizados.'],
            'success'   => true
        ]);
    }

    public function header(UpdateTemplateHeaderRequest $request, User $user, Event $personal_event)
    {
		if (!$personal_event->eventStatus->active) {
			return Response::json([
                'error' => ["Unauthorized"]
            ], 422);
		}

		$input = $request->all();

		$personal_event->description = $input['html'];

		if(!$personal_event->save())
        {
			return Response::json([
                'error' => ["No se pudo guardar diseño y paleta de colores"]
            ], 422);
        }

		$personal_event->eventTemplate->background_color = str_replace('#', '', $input['background_color']);
		$personal_event->eventTemplate->image_background_color = str_replace('#', '', $input['image_background_color']);
		$personal_event->eventTemplate->timer = isset($input['timer']);

		if(!$personal_event->eventTemplate->save())
        {
			return Response::json([
                'error' => ["No se pudo guardar diseño y paleta de colores"]
            ], 422);
        }

		return Response::json([
			'data'      => $personal_event->load([
				'eventTemplate',
				'eventTemplate.eventTemplateSections' => function($query){
					$query->orderBy('order');
				},
				'eventTemplate.eventTemplateSections.eventTemplateSectionType',
			]),
            'message'   => ["Portada actualizada correctamente"],
            'success'   => true
        ]);
    }

	public function publish(User $user, Event $personal_event)
    {
		if (!$personal_event->eventStatus->active) {
			return Redirect::back()->withErrors(['Unauthorized']);
		}

        if (!$personal_event->eventTemplate) {
        	return Redirect::back()->withErrors(['Hubo problemas publicando la web de tu evento.']);
        }

		if (!$personal_event->eventTemplate->eventTemplateHeader) {
        	return Redirect::back()->withErrors(['Selecciona un diseño para poder activar la web de tu evento.']);
        }

		if (!$personal_event->eventStatus->publish) {
			return Redirect::back()->withErrors(['Necesitas publicar tu evento antes para publicar tu web.']);
		}

		$personal_event->eventTemplate->publish = true;

		if(!$personal_event->eventTemplate->save()){
			return Redirect::back()->withErrors(['Hubo problemas publicando la web de tu evento.']);
		}

		return Redirect::back()->with('status', 'El evento se publicó correctamente.');
    }

	public function photos(CreatePhotoRequest $request, User $user, Event $personal_event)
	{
		if (!$personal_event->eventStatus->active) {
			return Response::json([
                'error' => ["Unauthorized"]
            ], 422);
		}

		$input = $request->all();

		$photoable_class = Photo::$associable_models[$input["photoable_type"]];

		$photoable = $photoable_class::find($input["photoable_id"]);

		$use_order_class = [
			"use"   => 'thumbnail',
			"order" => null,
			"class" => '',
		];

		$allow = false;

		if ($input["photoable_type"] == 'template' ) {
			$allow = $photoable->event->id == $personal_event->id;
		}elseif ($input["photoable_type"] == 'section') {
			$allow = $photoable->eventTemplate->event->id == $personal_event->id;
		}

		if (!$allow) {
			return Response::json([
                'error' => ["La imagen no pudo ser cargada"]
            ], 422);
		}

		$newImage = Photo::createImageFile($input["image"]);

        if (!$newImage) {
            return Response::json([
                'error' => ["La imagen no pudo ser cargada"]
            ], 422);
        }

		$photo = Photo::getPhotoCollectionByFileName($newImage)->first();

        if (!$photo) {
			$photo = Photo::create([
				"filename"  => $newImage,
				"type"      => $input["image"]->getMimeType(),
			]);
        }

		if (!$photo) {
			Storage::delete($file_path);
			Storage::delete(str_replace(Photo::STORAGE_PATH, Photo::THUMBNAILS_STORAGE_PATH, $file_path)  );
			return Response::json([
				'error' => ["La imagen no pudo ser salvada"]
			], 422);
		}

		$previous_image = $photoable->getFirstPhotoTo($use_order_class);

        if ($previous_image) {

			if (!$photoable->disassociateImage($previous_image, $use_order_class)) {
	            return Response::json([
	                'error' => ["La imagen anterior no pudo ser desasignada, ya cuenta con una imagen asignada previamente"]
	            ], 422);
	        }

        }

        if (!$photoable->associateImage($photo, $use_order_class)) {
            return Response::json([
                'error' => ["La imagen no pudo ser asignada"]
            ], 422);
        }

        return Response::json([ // todo bien
			'data'      => $personal_event->load([
				'eventTemplate',
				'eventTemplate.eventTemplateSections' => function($query){
					$query->orderBy('order');
				},
				'eventTemplate.eventTemplateSections.eventTemplateSectionType',
			]),
            'message' => ["La imagen ha sido asignada exitosamente."],
            'success' => true
        ]);
	}
}
