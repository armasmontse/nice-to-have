<?php

namespace App\Http\Controllers\Client\Events;

use Illuminate\Http\Request;

use App\Setting;
use App\Http\Requests;
use App\Models\Events\Event;
use App\Http\Controllers\ClientController;
use App\Http\Requests\Client\Events\EventsSearchRequest;

class SearchEventsController extends ClientController
{
    public function search(EventsSearchRequest $request)
    {
        if (!$request->has('s')) {
            
            $image = Setting::getEventImageSearch();

            $data = [
                'image' => $image
            ];

            return view('client.events.search.index', $data);
        }

        $search_words = trim($request->input("s")) ;

        $events_query = Event::where("feted_names",'like',"%".$search_words."%")
			->orWhere("name",'like',"%".$search_words."%")
			->orWhere("key",'like',"%".strtolower($search_words)."%")
            ->open()
            ->with(
                "eventStatus",
				"typeable",
				"eventTemplate"
            );

        $events = $events_query->get()->filter(function($event){
            return $event->in_time;
        });

        $data = [
            "events"        => $events, // falta filtrar y buscar
            "search_words"  => $search_words,
        ];

        return view('client.events.search.search', $data);

    }

}
