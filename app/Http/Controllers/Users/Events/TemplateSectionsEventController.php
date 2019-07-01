<?php

namespace App\Http\Controllers\Users\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Models\Events\EventTemplateSection;
use App\Models\Events\EventTemplateSectionType;

use App\Http\Requests\Users\Events\Templates\Sections\CreateSectionEventRequest;
use App\Http\Requests\Users\Events\Templates\Sections\SortSectionsEventRequest;
use App\Http\Requests\Users\Events\Templates\Sections\UpdateSectionEventRequest;

use App\User;
use App\Models\Events\Event;

use Response;

class TemplateSectionsEventController extends ClientController
{
    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateSectionEventRequest $request, User $user, Event $personal_event)
    {
        if (!$personal_event->eventStatus->active) {
			return Response::json([
                'error' => ["Unauthorized"]
            ], 422);
		}

        $input = $request->all();

        $last_section = $personal_event->eventTemplate->eventTemplateSections->sortBy('order')->last();

        $section_type = EventTemplateSectionType::find($input['section_type_id']);

        $template_section = $personal_event->eventTemplate->eventTemplateSections()->create([
            'event_template_section_type_id'    => $input['section_type_id'],
            'order'                             => $last_section && isset($last_section->order) ? $last_section->order + 1 : 0,
        ]);

        if (!$template_section) {
            return Response::json([
                'error' => ["No se pudo crear la sección."]
            ], 422);
        }

        return Response::json([
            'data'      => EventTemplateSection::find($template_section->id)->load('eventTemplateSectionType'),
            'message'   => ["Sección creada exitosamente."],
            'success'   => true
        ]);
    }

    public function sortSections(SortSectionsEventRequest $request, User $user, Event $personal_event)
    {
        if (!$personal_event->eventStatus->active) {
			return Response::json([
                'error' => ["Unauthorized"]
            ], 422);
		}

        $input = $request->all();

        $sortable_sections = $input['section_id'];

        foreach ($sortable_sections as $key => $section_id) {

            $template_section = EventTemplateSection::find($section_id);
            $template_section->order = $key + 1;

            if (!$template_section->save()) {
                return Response::json([
                    'error' => ["La sección no se pudo actualizar."]
                ], 422);
            }

        }

        return Response::json([
            'data'      => $personal_event->load([
				'eventTemplate',
				'eventTemplate.eventTemplateSections' => function($query){
					$query->orderBy('order');
				},
				'eventTemplate.eventTemplateSections.eventTemplateSectionType',
			]),
            'message'   => ["Orden actualizado exitosamente."],
            'success'   => true
        ]);
    }

    public function update(UpdateSectionEventRequest $request,User $user, Event $personal_event, EventTemplateSection $template_section)
    {
        if (!$personal_event->eventStatus->active) {
			return Response::json([
                'error' => ["Unauthorized"]
            ], 422);
		}

        $input = $request->all();

        $template_section->publish = isset($input['publish']);
        $template_section->background_color = str_replace('#', '', $input['background_color']);
        $template_section->title = $template_section->eventTemplateSectionType->rules['title'] ? $input['title'] : null;
        $template_section->link = $template_section->eventTemplateSectionType->rules['link'] ? $input['link'] : null;
        $template_section->html = $template_section->eventTemplateSectionType->rules['html'] ? $input['html'] : null;;
        $template_section->iframe = $template_section->eventTemplateSectionType->rules['iframe'] ? $input['iframe'] : null;;

        if (!$template_section->save()) {
            return Response::json([
                'error' => ["La sección no se pudo actualizar."]
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
            'message'   => ["Sección actualizada exitosamente."],
            'success'   => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Event $personal_event, EventTemplateSection $template_section)
    {
        if (!$personal_event->eventStatus->active) {
			return Response::json([
                'error' => ["Unauthorized"]
            ], 422);
		}

        if(!$template_section->eventTemplate()->dissociate()){
            return Response::json([
                'error' => ["No se pudo desasociar la sección."]
            ], 422);
        }

        if ($template_section->photos->count() > 0 ) {
            if(!$template_section->photos()->detach()){
                return Response::json([
                    'error' => ["No se pudieron desasociar las fotos."]
                ], 422);
            }
        }

        if (!$template_section->delete()) {
            return Response::json([
                'error' => ["No se pudo eliminar la sección."]
            ], 422);
        }

        return Response::json([
            'message'   => ["Sección eliminada exitosamente."],
            'success'   => true
        ]);
    }
}
