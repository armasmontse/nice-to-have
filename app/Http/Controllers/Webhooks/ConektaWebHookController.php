<?php

namespace App\Http\Controllers\Webhooks;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\Controller;

use File;

use Conekta;
use Conekta_Event;
use Conekta_Error;

use App\Models\Shop\Bag;
use App\Models\Shop\BagStatus;
use App\User;

use Illuminate\Support\Facades\Mail;
use App\Mail\Cltvo\FatalErrorMail;

use App\Notifications\Users\Events\EventPresentNotification;
use App\Notifications\Users\Shop\BuySuccessNotification;
use App\Notifications\Admin\Shop\AdminBuyNotification;
use App\Notifications\Users\Shop\PresentNotification;



class ConektaWebHookController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() // metodo de pruebas
    {
        // $path = $this->testFilePath();
        //
        // $class = json_decode(File::get($path)  ) ;

        // dd($class);

        // if (!$this->eventExistsOnConekta($class->id)) {
        //     return ;
        // }
        //
        // $conekta_id = $class->data->object->id;
        //
        // $bag_key =  $class->data->object->reference_id;
        //
        // $payment_method = $class->data->object->payment_method->type ;
        // $payment_status = $class->data->object->status;
        //
        // $bag = Bag::with("bagPayment","bagType")->where(["key" => $bag_key])->whereHas("bagPayment",function($q) use ($conekta_id,$payment_status){
        //     return $q->where(["payable_id" => $conekta_id,["payable_status" ,"!=", $payment_status]]);
        // })->first();
        //
        // if (!$bag) {
        //     return ;
        // }
        //
        //
        // $bag->bagPayment->payable_status = $payment_status;
        //
        // if ($payment_status == "paid") {
        //     $bag->bagPayment->paid_at = date("Y-m-d H:i:s");
        //
        //     if ($payment_method == "spei" && $bag->bagType->event) {
        //         // pasar las cosas de la bolsa al carrito del evento sergio pendiente
        //     }
        // }
        //
        // if (!$bag->bagPayment->save()) {
        //     // mandar notificacion de algo anda mal
        // }

        return "ok";

    }


    /**
     * Verify with Stripe that the event is genuine.
     *
     * @param string $id
     *
     * @return bool
     */
    protected function eventExistsOnConekta($id)
    {
        try {
            Conekta::setApiKey( env('CONEKTA_PRIVATE_KEY') );

            return !is_null(Conekta_Event::where(['id' => $id]));
        } catch (Conekta_Error $e) {
            return false;
        }
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $payload = json_decode($request->getContent());

        if (!$this->eventExistsOnConekta($payload->id)) {
            return ;
        }

        if (!$payload || !isset($payload->data) || !isset($payload->data->object) || !isset($payload->data->object->id) ||  !isset($payload->data->object->reference_id) ) {
            return ;
        }

        $conekta_object = $payload->data->object;
        $conekta_id = $conekta_object->id;
        $bag_key =  $conekta_object->reference_id;

        $payment_method = $conekta_object->payment_method->type ;
        $payment_status = $conekta_object->status;

        $bag = Bag::with("bagPayment","bagType")->where(["key" => $bag_key])->whereHas("bagPayment",function($q) use ($conekta_id,$payment_status){
            return $q->where(["payable_id" => $conekta_id,["payable_status" ,"!=", $payment_status]]);
        })->first();

        if (!$bag) {
            return ;
        }


        $bag->bagPayment->payable_status = $payment_status;

        if ($payment_status == "paid") {
            $bag->bagPayment->paid_at = date("Y-m-d H:i:s");

            $pagado = BagStatus::getStatusPaid();
            $bag->bag_status_id = $pagado->id;

            if ($payment_method == "spei" && $bag->bagType->event) {
                $bag_sku_responce = $bag->updateProtectedBag();

                if ( $bag_sku_responce["error"] ) {
                    $this->sendFatalErrorMail([$bag_sku_responce["error"]]);
                }
            }
        }

        if ( !$bag->save() ||  !$bag->bagPayment->save()) {
            $this->sendFatalErrorMail([trans('conekta.errors.add')]);
        }


        if ($payment_status == "paid" && $payment_method == "spei") {

            $refresh_bag = Bag::where('key', $bag->key)->get()->first();

            $refresh_bag->bagUser->user->notify(new BuySuccessNotification($refresh_bag));

            AdminBuyNotification::AdminNotify([ "active_bag" => $refresh_bag ]);

            if ($refresh_bag->bagType->event) {

                $refresh_bag->event->user->notify(new EventPresentNotification($refresh_bag));

            }elseif(!empty($refresh_bag->getPresentUrl()) && (!empty($refresh_bag->message) || $refresh_bag->bagShipping->address->email != $refresh_bag->bagUser->user->email)) {

                $friend = new User();
                $friend->email = $refresh_bag->bagShipping->address->email;
                $friend->name = $refresh_bag->bagShipping->address->contact_name;
                $friend->notify(new PresentNotification($refresh_bag));
            }
        }

        return;
    }

    protected function sendFatalErrorMail($error_data)
    {
        $code = trans('conekta.errors.update');

        Mail::to('hola@elcultivo.mx')->send(new FatalErrorMail($code, $error_data));

    }

    // public function testFilePath()
    // {
    //     return storage_path()."/app/cltvo/webhook.txt";
    // }


}
