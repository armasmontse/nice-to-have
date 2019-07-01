<?php

use Illuminate\Database\Seeder;

use App\Language;

use App\Models\Shop\Bag;
use App\Models\Shop\BagBilling;
use App\Models\Shop\BagPayment;
use App\Models\Shop\BagShipping;
use App\Models\Shop\BagStatus;
use App\Models\Shop\BagType;
use App\Models\Shop\BagUser;
use App\Models\Shop\BagDiscount;

use App\Models\Skus\Sku;

use App\Models\Products\Product;
use App\Models\Address\Country;
use App\Models\Address\Address;
use App\Models\Users\Card;
use App\Setting;
use App\User;
use App\Models\Events\Event;
use App\Models\Events\EventStatus;
use App\Models\Shop\Discounts\DiscountCode;

use Faker\Factory;

use Carbon\Carbon;

class BagsTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Factory::create();
        $languages = Language::GetLanguagesIso()->toArray();
        $users =  User::all();
        $skus = Sku::whereHas('product', function ($query) {
            $query->published();
        })->get();
        $addresses = Address::all();
        $countries = Country::all();
        $discount_codes = DiscountCode::all();

        factory(Bag::class, 10)->create()->each(function($bag) use ($languages, $faker, $users, $skus, $addresses, $countries, $discount_codes){

            // Buscamos un usuario para asignarle la bolsa que no tenga este tipo de bolsa activa.
            do {
                $user = $users->random(1);
                $active_bags = $user->bags()
                                ->whereHas('bagType', function($query) use ($bag) {
                                    $query->where('id', $bag->bagType->id);
                                })->whereHas('bagStatus', function($query){
                                    $query->where('active', true);
                                })->get();
            } while ($active_bags->count() > 0);

            // Asignamos la bolsa al usuario y la guardamos al bugUser.
            $bag_user = BagUser::create([
                "bag_id"    => $bag->id,
                "user_id"   => $user ? $user->id :null
            ]);

            if (!$bag_user) { return ; }

            // Buscamos al azar skus para relacionarle a la bolsa.
            do {
                $bag_skus = $skus->random(min(rand(2, 5), $skus->count()));
            } while ($bag_skus->count() < 2);

            // Recorremos la colección de skus para relacionarla con la bolsa.
            foreach ($bag_skus as $sku) {

                $pivot_args = [
                    'shipping_rate' => null,
                    'price'         => null,
                    'discount'      => null,
                    'quantity'      => rand(1, 5)
                ];

                // Le guardamos el sku a esa bolsa.
                if (!$bag->skus()->save($sku, $pivot_args)) { return; }

            }

            if (!$bag->bagStatus->active) {

                $this->payBag($bag, $faker, $addresses, $countries);

                $bagBilling = rand(0, 1);

                if ($bagBilling) {

                    $address= Address::get()->random(1);

                    if (!$address) { return ; }

                    $bagBilling_args = [
                        'bag_id'        => $bag->id,
                        'address_id'    => $address->id,
                        'rfc'           => $faker->regexify('^[A-Za-z]{4}\-\d{6}(?:\-[A-Za-z\d]{3})?$'),
                        'razon_social'  => $faker->company,
                        'info'          => '' ,
                        'status'        => "Requerida",
                        'request'       => true,
                    ];

                    $bag_bagBilling = $bag->bagBilling;

                    if (!$bag_bagBilling) {

                        $bag_bagBilling = BagBilling::create( $bagBilling_args );

                        if (!$bag_bagBilling) { return ; }
                    }

                }

                if ($bag->bagStatus->cancel && $bag->bagType->event && !$bag->bagType->special && !$bag->chargeback) {

                    $chargeback = $bag->chargeback()->create([
                        'info'      => $bag->status_info,
                        'event_id'  => $bag->event->id,
                        'amount'    => $bag->bagPayment->total,
                    ]);

                }

            }

            // Asignamos la bolsa al código de descuento y la guardamos en bagDiscount.
            $bag_discounts = BagDiscount::create([
                'bag_id'            => $bag->id,
                'discount_code_id'  => $discount_codes->random(1)->id,
                'amount'            => rand(1, 1000)
            ]);

            if(!$bag_discounts)
            {
                return;
            }

        });

        $event_expiration = Setting::getEventExpiration();
        $date = Carbon::now();
        $close_day = $date->subMonths($event_expiration);
        $close_day->setTimezone('UTC');
        $finished_status = EventStatus::getFinish();
        $events = Event::whereDate('date', '<=' , $close_day->toDateString())->orWhereHas('eventStatus', function ($query) use ($finished_status) { $query->where('id', '=', $finished_status->id); })->get();

        foreach ($events as $event) {
            $close_event_response = $event->closeEvent();
        }

    }

    private function payBag($bag, $faker, $addresses, $countries)
    {
        $totals = [
            'subtotal'          => $bag->bag_totals["price_with_discounts"],
            'shipping_rate'     => 0.0,
            'print_message'     => 0.0,
            'discount'          => -0.0,
        ];

        $in_ZMVM = false;
        $someonelse = false;

        if (!$bag->bagType->event) {

            $someonelse = rand(0, 1);

            $address = $someonelse ? $addresses->random(1) : $bag->bagUser->user->getMainAddress();

            if (!$address) {
                $country = $countries->random(1);
                $address = Address::create([
                    'country_id'    => $country->id,
                    'contact_name'  => $faker->name,
                    'phone'         => $faker->phoneNumber,
                    'references'    => $faker->secondaryAddress,
                    'street1'       => $faker->streetName ,
                    'street2'       => $faker->buildingNumber ,
                    'street3'       => mt_rand(1, 10000) <= 1/4 * 10000 ? $faker->streetAddress  : '',
                    'city'          => $faker->city ,
                    'state'         => $faker->state ,
                    'zip'           => $faker->postcode
                ]);
            }

            $in_ZMVM = Country::inZMVM($address->state, $address->street2);
            $totals['shipping_rate'] += $in_ZMVM ? $bag->bag_totals['local_shipping_rate'] : $bag->bag_totals['national_shipping_rate'];

            // Guardamos el shipping address.
            $bag_shipping_args = [
                'bag_id'        => $bag->id,
                'info'          => 'nice-to-have',
                'rate'          => $totals["shipping_rate"],
                'method'        => 'estandar',
                'address_id'    => $address->id,
                'tracking_code' => "",
            ];

            if (!BagShipping::create($bag_shipping_args)) { return; }
        }

        $extra_info = null;

        if ($someonelse || $bag->bagType->event) {
            $print_message = rand(0 ,1) ? $faker->sentence : null;
            $totals["print_message"] += $print_message ? Setting::getPrintMessageCost() : 0.0;
            $extra_info['print_message_cost'] = $totals["print_message"];
        }

        // Guardamos el cobro.
        if ($bag->bagStatus->paid) {
            $payment_method = rand(0, 1) ? 'tarjeta' : 'spei';
        }else {
            $payment_method = 'spei';
        }

        if ($payment_method == "spei" ) {

            $extra_info['bank'] = 'STP';
            $extra_info['clabe'] = '646180111812345678';

            $payable_type = 'conekta bank_transfer_payment spei';
            $payable_status = $bag->bagStatus->paid ? 'paid' : 'pending_payment';

        }else {

            $payable_type = 'conekta card_payment credit';
            $payable_status = 'paid';

        }

        if ($bag->bagType->event) {
            $now = Carbon::now();
            $diff = $now->diff($bag->event->date)->m > 2 ? 5 : $now->diff($bag->event->date)->m + 2;
        }

        $paid_date = !$bag->bagType->event ? $faker->dateTimeInInterval('-6 months') : $faker->dateTimeInInterval($bag->event->date->sub(new DateInterval('P3M')), '+ ' . $diff . ' months');

        $bag_payment_args = [
            'bag_id'            => $bag->id,
            'payable_id'        => str_random(24),
            'payable_type'      => $payable_type,
            'payable_status'    => $payable_status,
            'currency'          => 1.00,
            'currency_type'     => 'MXN',
            'total'             => array_sum($totals),
            'paid_at'           => $bag->bagStatus->paid ? $paid_date : null,
            'extra_info'        => $extra_info,
        ];

        if (!BagPayment::create($bag_payment_args)) { dd('Murió'); }

        // Guardamos la info del usuario

        $user_args = [
            'accept_terms'  => true,
            'name'          => $bag->bagUser->user->full_name ,
            'email'         => $bag->bagUser->user->email,
            'phone'         => $faker->phoneNumber,
            'info'          => '',
        ];

        if (!$bag->updateBagUser($user_args)) { dd('murió bagUser'); }

        // Guardamos la info de los skus

        if (!$bag->updateBagSku($in_ZMVM)) { dd('murió updateBagSku'); }

        if ($bag->bagType->event  && $bag->bagStatus->paid) {
            $bag->updateProtectedBag();
        }

        // Actualizamos la bolsa.
        if (($someonelse || $bag->bagType->event) && $print_message) {
            $bag->message = $print_message;
            $bag->print_message = true;
        }

        $bag->purshased_at = $paid_date;

        if (!$bag->save() ) { return; }
    }


}
