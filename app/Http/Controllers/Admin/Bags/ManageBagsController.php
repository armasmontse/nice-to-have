<?php

namespace App\Http\Controllers\Admin\Bags;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use App\Language;

use App\Models\Shop\Bag;
use App\Models\Shop\BagBilling;
use App\Models\Shop\BagPayment;
use App\Models\Shop\BagShipping;
use App\Models\Shop\BagStatus;
use App\Models\Shop\BagType;
use App\Models\Shop\BagUser;

use App\Models\Events\Chargeback;

use App\Http\Requests\Admin\Bags\UpdateStatusRequest;
use App\Http\Requests\Admin\Bags\UpdateBillingRequest;
use App\Http\Requests\Admin\Bags\UpdateShippingRequest;

use App\Notifications\Users\Shop\CancelBagNotification;
use App\Notifications\Users\Shop\BillingUpdateStatusNotification;
use App\Notifications\Users\Shop\UpdateBagStatusNotification;

use Response;
use Redirect;

class ManageBagsController extends Controller
{
    public function index()
    {
        $data = [
            'bags' => Bag::with('bagBilling', 'bagBilling.address', 'bagBilling.address.country', 'bagStatus', 'bagType', 'bagUser', 'bagUser.user', 'bagShipping', 'bagShipping.address', 'bagShipping.address.country', 'bagPayment', 'skus', 'event' )->get(),
        ];

        return view('admin.bags.index', $data);
    }

    /**
    * Edit bag
    *
    * @return \Illuminate\Http\Response
    **/
    public function edit(Bag $admin_payed_bag)
    {
        $data = [
            'bag'           => $admin_payed_bag,
            'bags_status'   => BagStatus::where('paid', true)->get()->pluck('label', 'id'),
            'bag_billing'   => BagBilling::with('address', 'address.country')->where('bag_id', $admin_payed_bag->id)->get()->first()
        ];

        return view('admin.bags._edit', $data);
    }

    public function updateBilling(UpdateBillingRequest $request, $admin_payed_bag)
    {
        $input = $request->all();

        $admin_payed_bag->bagBilling->status = $input['billing_status'];

        if (!$admin_payed_bag->bagBilling->save()) {
            return Redirect::back()->withErrors(["No se pudo actualizar el status de la factura."]);
        }

        $admin_payed_bag->bagUser->user->notify( new BillingUpdateStatusNotification($admin_payed_bag));

        return Redirect::back()->with('status', "El status de la factura fue actualizado correctamente");
    }

    public function updateStatus(UpdateStatusRequest $request, $admin_payed_bag)
    {
        $input = $request->all();

        $admin_payed_bag->bag_status_id = $input['status_id'];
        $admin_payed_bag->status_info = $input['status_info'];

        if (!$admin_payed_bag->save()) {
            return Redirect::back()->withErrors(["No se pudo actualizar el status de la bolsa."]);
        }

        $newBagStatus = BagStatus::find($input['status_id']);

        if ($newBagStatus->cancel) {

            $admin_payed_bag->bagUser->user->notify( new CancelBagNotification($admin_payed_bag));

            if ($admin_payed_bag->bagType->event && !$admin_payed_bag->bagType->special) {

                if (!$admin_payed_bag->chargeback) {
                    $chargeback = $admin_payed_bag->chargeback()->create([
                        'info'      => $admin_payed_bag->status_info,
                        'event_id'  => $admin_payed_bag->event->id,
                        'amount'    => $admin_payed_bag->bagPayment->total,
                    ]);
                }

            }

        }else {

            $admin_payed_bag->bagUser->user->notify( new UpdateBagStatusNotification($admin_payed_bag->load('bagStatus')));

        }

        return Redirect::back()->with('status', "El status de la bolsa fue actualizado correctamente");
    }

    public function updateShipping(UpdateShippingRequest $request, $admin_payed_bag)
    {
        $input = $request->all();

        $admin_payed_bag->bagShipping->tracking_code = isset($input['shipping_tracking_code']) ? $input['shipping_tracking_code'] : '';
        $admin_payed_bag->bagShipping->method = isset($input['shipping_method']) ? $input['shipping_method'] : '';
        $admin_payed_bag->bagShipping->info = isset($input['shipping_info']) ? $input['shipping_info'] : '';

        if (!$admin_payed_bag->bagShipping->save()) {
            return Redirect::back()->withErrors(["No se pudo actualizar el envío de la bolsa."]);
        }

        return Redirect::back()->with('status', "El shipping de la bolsa fue actualizado correctamente");
    }

}
