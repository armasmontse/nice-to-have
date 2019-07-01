<?php

namespace App\Http\Binds\Events;

use App\Http\Binds\CltvoBind;
use App\Models\Events\Event;
use Route;

class ManageEventsBind extends CltvoBind
{
    public static function Bind()
    {
        Route::bind('event', function ($event_id){
            return Event::where('id', $event_id)->get()->first();
        });

        Route::bind('template_section', function ($template_section_id, $route){
            $event = $route->parameters()['personal_event'];
            return $event->eventTemplate->eventTemplateSections()->where('id', $template_section_id)->get()->first();
        });
    }
}
