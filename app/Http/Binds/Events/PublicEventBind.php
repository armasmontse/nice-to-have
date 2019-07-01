<?php

namespace App\Http\Binds\Events;

use App\Http\Binds\CltvoBind;

use Auth;
use Route;

use App\Models\Events\EventStatus;

class PublicEventBind extends CltvoBind
{

    /**
     * bind methods
     */
    public static function Bind(){

    // para los subdominios y templates
        Route::bind('public_event_with_template', function ($event_slug) {
            $event = EventStatus::getPublish()
                ->events()
                ->where(["slug"=>$event_slug ])
				->whereHas('eventTemplate', function ($query) {
				    $query->where(['publish' => true]);
				})
                ->with(
                    "typeable",
                    "eventTemplate",
                    "eventTemplate.eventTemplateHeader",
                    "eventTemplate.photos",
                    "eventTemplate.eventTemplateSections",
                    "eventTemplate.eventTemplateSections.photos",
                    "eventTemplate.eventTemplateSections.eventTemplateSectionType"
                )
                ->first();

            if (Auth::user() && !$event) {
                $event = Auth::user()
                  ->events()
                  ->where(["slug"=>$event_slug ])
                  ->with(
                      "typeable",
                      "eventTemplate",
                      "eventTemplate.eventTemplateHeader",
                      "eventTemplate.photos",
                      "eventTemplate.eventTemplateSections",
                      "eventTemplate.eventTemplateSections.photos",
                      "eventTemplate.eventTemplateSections.eventTemplateSectionType"
                  )
                  ->first();
            }
            return $event;
        });

    // para las mesas de regalos
        Route::bind('public_event', function ($event_slug) {
            $events = EventStatus::getPublish()
                ->events()
                ->where(["slug"=>$event_slug ])
                ->with(
                    "typeable"
                )->get();

            if (Auth::user() && $events->isEmpty()) {
                $events = Auth::user()
                  ->events()
                  ->where(["slug"=>$event_slug ])
                  ->with(
                      "typeable"
                  )->get();
            }

            $event = $events->first();
            return $event && $event->in_time ? $event : null ;

        });

        Route::bind('personal_event', function ($event_slug) {

            return  Auth::user()
                ->events()
                ->where(["slug"=>$event_slug ])
                ->with(
                    "typeable",
					"eventStatus",
					"eventTemplate",
					"bags",
					"cashouts"
                )
                ->first();
        });
    }

}
