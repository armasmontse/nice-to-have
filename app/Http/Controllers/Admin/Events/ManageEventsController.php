<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;
use App\Http\Requests\Admin\Events\UpdateEventRequest;
use App\Http\Controllers\Controller;
use App\Models\Events\Event;
use Redirect;

use App\Models\Events\CashOutStatus;

use App\Setting;

class ManageEventsController extends Controller
{
    public function index()
    {
        $data = [
            "events" => Event::all()->sortBy('created_at'),
        ];

        return view('admin.events.index', $data);
    }

    public function show(Event $event)
    {

        $data = [
            'event'             => $event,
            'bags'	            => $event->bags()->orderBy("purshased_at", "DESC")->with('skus', 'skus.product')->eventNotSpecialNotProtected()->paid()->get(),
            'cashouts'          => $event->cashOuts()->with('event', 'cashOutStatus', 'bank_account')->get(),
            'cashouts_status'   => CashOutStatus::all(),
            'percentage'        => 100 - Setting::getCheckoutMinPercentage(),
            'event_address'     => $event->getMainAddress()
        ];

        return view('admin.events.show', $data);
    }

    public function update(UpdateEventRequest $request, Event $event)
    {
        $input = $request->all();

        $event->exclusive = $input['exclusive'];

        if (!$event->save())
        {
            return Redirect::back()->withErrors(['No se pudo actualizar la exclusividad del evento.']);
        }

        return Redirect::back()->with('status', 'Exclusividad del evento correctamente actualizada.');
    }

}
