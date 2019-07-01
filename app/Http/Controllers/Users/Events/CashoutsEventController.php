<?php

namespace App\Http\Controllers\Users\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Http\Requests\Users\Cashouts\CreateCashoutRequest;

use App\Notifications\Users\Events\CashOutsSuccessRequestNotification;
use App\Notifications\Admin\Events\AdminCashOutsSuccessRequestNotification;

use App\User;
use App\Models\Events\Event;
use App\Setting;
use App\Models\Events\CashOut;
use App\Models\Events\CashOutStatus;

use Redirect;

class CashoutsEventController extends ClientController
{
	/**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user, Event $personal_event)
    {
    	$cashout = $personal_event->not_canceled_cash_outs->first();

		$data = [
			'personal_event'		=> $personal_event,
			'cashout_min_amount'	=> Setting::getCashoutMinAmount(),
			'cashout_date'			=> !$cashout ? 'Ninguna' : $cashout->create_date_for_humans,
			'cashout_amount'		=> !$cashout ? '0.00' : number_format($cashout->total,2,'.',','),
			'cashout_fee'			=> !$cashout ? '0.00' : number_format($cashout->total - $cashout->total_out,2,'.',','),
			'cashout_transfer'		=> !$cashout ? '0.00' : number_format($cashout->total_out,2,'.',','),
			'cashout_status'		=> !$cashout ? 'Ninguna' : $cashout->cashOutStatus->label
		];

		return view('users.events.cashouts.index', $data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(CreateCashoutRequest $request,  User $user, Event $personal_event)
    {
		$required_status = CashOutStatus::required()->first();

		$input = $request->all();

		$total = floatval($input["amount"]);

		$cash_out = CashOut::create([
			'event_id'				=> $personal_event->id,
			'cash_out_status_id'	=> $required_status->id,

			'info' 					=> '',

			'bank_account_id'		=> $input['bank_account_id'],
	        'total'					=> $total,
	        'total_out'				=> $total*(1-$personal_event->current_fee_percentage/100)
		]);

		if (!$cash_out) {
			return Redirect::back()->withErrors([trans('cash_out.errors.cant_create')]);
		}

		$user->notify( new CashOutsSuccessRequestNotification([ 'personal_event' => $personal_event , 'cash_out' => $cash_out->load("bank_account") ]));

		AdminCashOutsSuccessRequestNotification::AdminNotify([ 'personal_event' => $personal_event , 'cash_out' => $cash_out->load("bank_account") ]);

		return Redirect::back()
			->with('status', trans('cash_out.success.create'));
    }

}
