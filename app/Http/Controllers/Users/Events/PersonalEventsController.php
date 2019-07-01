<?php

namespace App\Http\Controllers\Users\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Http\Requests\Users\Events\CreateEventRequest;

use App\Models\Products\Product;

use App\Models\Events\Event;
use App\Models\Events\Type;
use App\Models\Events\Subtype;
use App\Models\Events\EventStatus;
use App\Setting;
use App\Models\Events\EventTemplate;

use App\Notifications\Users\Events\CreateEventNotification;
use App\Notifications\Admin\Events\AdminCreateEventNotification;

use App\User;

use Carbon\Carbon;

use Redirect;

class PersonalEventsController extends ClientController
{

	public function create(User $user)
    {
		$images = Setting::getCreateEventImages();

		$step_2_image = $images->getFirstPhotoTo( [ 'use' => 'thumbnail', 'order' => 2 ] );
		$step_3_image = $images->getFirstPhotoTo( [ 'use' => 'thumbnail', 'order' => 3 ] );
		$step_4_image = $images->getFirstPhotoTo( [ 'use' => 'thumbnail', 'order' => 4 ] );
		$step_5_image = $images->getFirstPhotoTo( [ 'use' => 'thumbnail', 'order' => 5 ] );

        $data = [
			'new_event'	=> session("new_event"),
			'images'	=>	[
				'step_2' => isset($step_2_image) ? $step_2_image->url : null,
				'step_3' => isset($step_3_image) ? $step_3_image->url : null,
				'step_4' => isset($step_4_image) ? $step_4_image->url : null,
				'step_5' => isset($step_5_image) ? $step_5_image->url : null,
			],
        ];

        return view('client.events.create', $data);
    }

	/**
	 * Store a newly created resource in storage.
	 *
	 * @param  \Illuminate\Http\Request  $request
	 * @return \Illuminate\Http\Response
	 */
	public function store(CreateEventRequest $request,User $user)
	{
		$input = $request->all();

		$draf = EventStatus::where([
			'active'	=> true,
			'publish'	=> false
		])->first();

		$new_event = Event::create([
			'user_id'			=> $this->user->id,
			'key'				=> Event::generateUniqueKey($input['name'], Carbon::parse($input['date'])->format('d-m-y')),

			'name'				=> $input['name'],
			'slug'				=> Event::generateUniqueSlug($input['name']) ,

			'feted_names'		=>	$input['feted_names'],

			"date"				=>	$input['date'],
			"description"		=> "",
			// "timezone"			,

			'accept'			=>	isset($input['accept']) && $input['accept'],
			'exclusive'			=>	$input['exclusive'],

			'event_status_id'	=> $draf->id,

			'typeable_id'		=> empty($input["subtype_id"]) ? $input["type_id"] : $input["subtype_id"],
			'typeable_type'		=> empty($input["subtype_id"]) ? Type::class : Subtype::class,
		]);

		if ( !$new_event || !$new_event->eventTemplate()->create([]) ) {
			return Redirect::back()->withErrors([trans('events.errors.cant_create')]);
		}

		$user->notify(new CreateEventNotification(['event' => $new_event]));

		AdminCreateEventNotification::AdminNotify(['event' => $new_event]);

		return Redirect::back()
			->with('status', trans('events.success.create'))
			->with('new_event', Event::where(["id" => $new_event->id])->first() );
	}

}
