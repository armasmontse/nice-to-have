<?php

namespace App\Http\Controllers\Users\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\User;

use App\Models\Events\Event;
use App\Models\Events\EventStatus;
use App\Models\Events\Subtype;
use App\Models\Events\Type;
use App\Models\Address\Country;

use App\Http\Requests\Users\Events\PublishPersonalEventRequest;
use App\Http\Requests\Users\Events\FinishPersonalEventRequest;
use App\Http\Requests\Users\Events\UpdatePersonalEventRequest;
use App\Http\Requests\Users\Events\AddressPersonalEventRequest;

use App\Notifications\Users\Events\CloseEventNotification;
use App\Notifications\Admin\Events\AdminCloseEventNotification;

use App\Setting;

use Redirect;
use Carbon\Carbon;

class ProfileEventController extends ClientController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Event $personal_event)
    {
        abort_if($personal_event->is_finish, 404);

		$data = [
			"countries_list"       => Country::with("languages")
			                            ->OrderedBy("official_name")
			                            ->where(["iso3166" => "MX"])
			                            ->get()
			                            ->pluck("official_name","id"),
			'address'	=> 	$personal_event->getMainAddress(),
			'mexico_states_and_mun' => Country::getMexicoStatesiWithMunicipies(),
			'personal_event'	=> $personal_event,
			'time_zones_list'   => collect(timezone_identifiers_list())->mapWithKeys(function($timezone){
                return [$timezone => $timezone];
            }),
		];

		return view('users.events.profile', $data);
    }

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function update(UpdatePersonalEventRequest $request,  User $user, Event $personal_event)
	{
        abort_if($personal_event->is_finish, 404);

		$input = $request->all();

		$personal_event->date				=	Carbon::parse($input['date']." ".$input['hour']);
		$personal_event->timezone			=	$input['timezone'];

		if ($personal_event->is_draft) {
			$personal_event->typeable_id		= empty($input["subtype_id"]) ? $input["type_id"] : $input["subtype_id"];
			$personal_event->typeable_type		= empty($input["subtype_id"]) ? Type::class : Subtype::class;

			$personal_event->name				= $input['name'];
			$personal_event->slug				= $input['slug'] ;
			$personal_event->feted_names		= $input['feted_names'];
		}

		if (!$personal_event->save()) {
			return Redirect::to($personal_event->perfil_url)->withErrors([trans('events.errors.cant_update')]);
		}

		return Redirect::to($personal_event->perfil_url)
			->with('status', trans('events.success.update'));

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function publish(PublishPersonalEventRequest $request,  User $user, Event $personal_event)
	{
        abort_if(!$personal_event->is_draft, 404);

		$personal_event->event_status_id = EventStatus::getPublish()->id;

		if (!$personal_event->save()) {
			return Redirect::back()->withErrors([trans('events.errors.cant_publish')]);
		}

		return Redirect::back()
			->with('publish_event', true )
			->with('status', trans('events.success.publish'));

	}

    /**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function finish(FinishPersonalEventRequest $request,  User $user, Event $personal_event)
	{
        abort_if(!$personal_event->is_publish, 404);

        $close_event_response = $personal_event->closeEvent();

        if ($close_event_response['type'] == 'error') {
            return Redirect::back()->withErrors([$close_event_response['message']]);
        }

        $personal_event->user->notify(new CloseEventNotification(['event' => $personal_event]));

        AdminCloseEventNotification::AdminNotify(['event' => $personal_event]);

		return Redirect::to($personal_event->bag_url)
			->with('finish_event', true )
			->with('status', trans('events.success.finish'));

	}

	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function address(AddressPersonalEventRequest $request,  User $user, Event $personal_event)
	{
        abort_if($personal_event->is_finish, 404);

		$input = $request->all();

		if (!$personal_event->updateAddressToUse($input['address'],"main")) {
			return Redirect::back()->withErrors([trans('events.errors.cant_update_address')]);
		}

		return Redirect::back()
			->with('status', trans('events.success.update_address'));

	}

	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function account(User $user, Event $personal_event)
    {
        abort_if($personal_event->is_draft, 404);

		$data = [
            'movements'      => $personal_event->movements(),
			'personal_event' => $personal_event,
            'percentage'     => 100 - Setting::getCheckoutMinPercentage(),
		];

		return view('users.events.account', $data);
    }
	/**
	 * Display a listing of the resource.
	 *
	 * @return \Illuminate\Http\Response
	 */
	public function gifts(User $user, Event $personal_event)
	{
        abort_if($personal_event->is_draft, 404);

		$data = [
			'personal_event'     => $personal_event,
            'bags'	             => $personal_event->bags()->with('skus', 'skus.product')->eventNotSpecialNotProtected()->paid()->get(),
		];

		return view('users.events.gifts', $data);
	}
}
