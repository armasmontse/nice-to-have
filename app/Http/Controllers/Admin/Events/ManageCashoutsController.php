<?php

namespace App\Http\Controllers\Admin\Events;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Http\Requests\Admin\Events\Cashouts\UpdateStatusRequest;

use App\Notifications\Users\Events\CashOutsUpdateStatusNotification;

use Response;

use App\Models\Events\CashOut;
use App\Models\Events\CashOutStatus;


class ManageCashoutsController extends Controller
{
    public function index()
    {
        $data = [
            'cashouts'          => CashOut::with('event', 'cashOutStatus', 'bank_account')->get(),
            'cashouts_status'   => CashOutStatus::all(),
        ];

        return view('admin.cashouts.index', $data);
    }

    public function update(UpdateStatusRequest $request, CashOut $cashout)
    {
        $input = $request->all();

        $cashout->cash_out_status_id = $input['status_id'];
        $cashout->info = $input['status_info'];

        if (!$cashout->save()) {
            return Response::json([
                'error' => ["No se pudo actualizar el estatus del retiro."]
            ], 422);
        }

        $cashout->event->user->notify( new CashOutsUpdateStatusNotification($cashout->event, $cashout));

        return Response::json([
            'data' => CashOut::with('event', 'cashOutStatus', 'bank_account')->find($cashout->id),
            'message' => ["El estatus del retiro fue actualizado correctamente"],
            'success' => true
        ]);
    }

}
