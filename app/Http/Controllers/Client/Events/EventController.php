<?php

namespace App\Http\Controllers\Client\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Requests\Client\ConfirmAttendanceRequest;

use App\Notifications\Users\Events\ConfirmAttedaceNotification;
use App\Notifications\Users\Events\ThanksForConfirmAttedaceNotification;

use App\User;
use App\Models\Events\Event;

use App\Http\Controllers\ClientController;

use Carbon\Carbon;

use Redirect;

use Route;

class EventController extends ClientController
{
    public function show(Event $public_event_with_template)
    {
        // Si no se ha elegido un diseño se manda un mensaje de error para que se elija uno
        if(!$public_event_with_template->template_view)
        {
            return Redirect::back()->with('status', trans('events.errors.no_template_view'));
        }

        $data = [
            "event"             => $public_event_with_template,
            "template_name"     => $public_event_with_template->template_view,
            "template"          => $public_event_with_template->eventTemplate,
            'sections'          => $public_event_with_template->eventTemplate->eventTemplateSections()->where('publish', true)->orderBy('order')->get()
        ];

        return view('client.events.show', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function register()
    {
        return view("auth.register");
    }

    public function confirmAttendance(ConfirmAttendanceRequest $request, Event $public_event)
    {
        $input = $request->all();

        $assistant = [
                'mail'  => $input['email'],
                'names' => array_map('trim', explode(',', $input['inputname'])),
        ];

        $assistant_user         = new User();
        $assistant_user->email  = $input['email'];

        $public_event->user->notify( new ConfirmAttedaceNotification($public_event, $assistant) );

        $assistant_user->notify( new ThanksForConfirmAttedaceNotification($public_event, $assistant) );

        return Redirect::back()->with('status', trans('events.success.assistance'));
    }

    public function setCookie(Event $public_event)
    {
        if (!$public_event->in_time) {
            return Redirect::route("client::events.search")->withErrors([trans('events.errors.event_closed')]);
        }
        return Redirect::to($public_event->shop_url)->withCookie('event',$public_event->key, Event::COOKIE_TIME);
    }
}
