<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

use DB;

use App\User;

use App\Models\Skus\Sku;

use App\Models\Events\Event;

use App\Models\Products\Product;

use App\Models\Address\Address;

use App\Models\Events\Chargeback;

use App\Models\Shop\Discounts\DiscountCode;

class Bag extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bags';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key', //
        'bag_status_id',
        'bag_type_id',
        'message',
        'print_message',
        "event_id",
    ];



    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bag_status_id'     => "integer",
        'bag_type_id'       => "integer",
        "event_id"          => "integer",
        'print_message'     => "boolean",
        'purshased_at'      => 'date',
    ];

    protected $appends = [
        'edit_bag_url'
    ];

    protected $local_shipping_rate;

    public function bagStatus()
    {
        return $this->belongsTo(BagStatus::class);
    }

    public function bagType()
    {
        return $this->belongsTo(BagType::class);
    }

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function bagShipping()
    {
        return $this->hasOne(BagShipping::class);
    }

    public function bagBilling()
    {
        return $this->hasOne(BagBilling::class);
    }

    public function bagPayment()
    {
        return $this->hasOne(BagPayment::class);
    }

    public function bagDiscount()
    {
        return $this->hasOne(BagDiscount::class);
    }

    public function chargeback()
    {
        return $this->hasOne(Chargeback::class);
    }

    public function bagUser()
    {
        return $this->hasOne(BagUser::class);
    }

    public function skus()
    {
        return $this->belongsToMany(Sku::class, 'bag_sku', 'bag_id', 'sku_sku')->withPivot(['parent_bag_id', 'quantity', 'price', 'discount', 'shipping_rate'])->withTimestamps();
    }

    public static function getByKey($key)
    {
        return static::ByKey($key)->first();
    }

    public function getIsActiveAttribute()
	{
		return $this->bagStatus->active;
	}

    public function scopeByKey($query, $key)
    {
        return $query->where([
            'key' => $key
        ]);
    }

    public function scopeByKeys($query, array $keys)
    {
        return $query->whereIn('key', $keys);
    }

    public function scopeActives($query)
    {
        return $query->with("bagStatus")
            ->whereHas('bagStatus', function ($q) {
                $q->where(["active" => true ]);
            });
    }

    public function scopeInActives($query)
    {
        return $query->with("bagStatus")
            ->whereHas('bagStatus', function ($q) {
                $q->where(["active" => false ]);
            });
    }

    public function scopeNotPaid($query)
    {
        return $query->with("bagStatus")
            ->whereHas('bagStatus', function ($q) {
                $q->where(["paid" => false ]);
            });
    }

    public function scopeForEvent($query, Event $event = null)
    {
        if ($event) {
            $query = $query->where(["event_id" => $event->id]);
        }
        return $query;
    }

    public function scopeNotProtected($query)
    {
        return $query->with("bagType")
            ->whereHas('bagType', function ($q) {
                $q->where(["protected" => false ]);
            });
    }

    public function scopeSpecial($query)
    {
        return $query->with("bagType")
            ->whereHas('bagType', function ($q) {
                $q->where(["special" => true ]);
            });
    }

    public function scopeNotSpecial($query)
    {
        return $query->with("bagType")
            ->whereHas('bagType', function ($q) {
                $q->where(["special" => false ]);
            });
    }

    public function scopeEventProtected($query)
    {
        return $query->with("bagType")
            ->whereHas('bagType', function ($q) {
                $q->where([
                    "protected" => true,
                    "event"     => true,
                    "special"   => true,
                 ]);
            });
    }

    public function scopeEventSpecialNotProtected($query)
    {
        return $query->with("bagType")
            ->whereHas('bagType', function ($q) {
                $q->where([
                    "event"     => true,
                    "special"   => true,
                    "protected" => false,
                 ]);
            });
    }

    public function scopeEventNotSpecialNotProtected($query)
    {
        return $query->with("bagType")
            ->whereHas('bagType', function ($q) {
                $q->where([
                    "event"     => true,
                    "special"   => false,
                    "protected" => false,
                 ]);
            });
    }

    public function scopeByTypeId($query, $bag_type_id)
    {
        return $query->where(["bag_type_id" => $bag_type_id]);
    }

    public function scopeValidPaid($query)
    {
        return $query->with("bagStatus")
            ->whereHas('bagStatus', function ($q) {
                $q->where(["paid" => true , "cancel" => false ]);
            });
    }

    public function scopePaid($query)
    {
        return $query->with("bagStatus")
            ->whereHas('bagStatus', function ($q) {
                $q->where("paid", true);
            });
    }

    public function scopeActivesFor($query, User $user = null)
    {
        return $query->with("bagUser")
            ->whereHas("bagUser", function ($q) use ($user) {
                $q->where(["user_id" => $user ? $user->id : null ]);
            })
            ->Actives();
    }

    public static function createBag(User $user = null, BagType $bag_type, Event $event = null)
    {
        $active = BagStatus::getActiveStatus();

        $bag = static::create([
            'key'           => static::generateUniqueKey(),
            'bag_status_id' => $active->id,
            'bag_type_id'   => $bag_type->id,
            "event_id"      => ($bag_type->event && $event) ? $event->id : null ,
        ]);

        $bag_user = BagUser::create([
            "bag_id"    => $bag->id,
            "user_id"   => $user ? $user->id :null
        ]);

        return $bag;
    }

    public function getProtectedBagForThisEvent()
    {
        if (!$this->bagType->event) {
            return null;
        }

        $protected_type = BagType::getProtectedSpecialEventType();

        if ($this->event->getEventProtectedBag()) {
            return $this->event->getEventProtectedBag();
        }

        $protected_bag = Bag::createBag($this->event->user, $protected_type, $this->event);

        return $protected_bag;
    }

    /**
    * Genera una referencia aleatoria unica para cada tranzaccion
    * @return string clave aleatoria de 15 digitos, cuatro digitos entre el 0-9, tres entre la a-z y segundos que lleva el año
    */
    public static function generateUniqueKey()
    {
        $breack = false;

        while (!$breack) {

            // genera clave aleatoria

            $key = "";

            for ($i=0; $i < 15 ; $i++) {
                $key .= rand(0, 9) <= 6 ? chr(rand(ord('a'), ord('z'))) : rand(0, 9);
            }

            $movements = static::where(["key" => $key])->get();

            if ($movements->count() == 0) {
                $breack = true ;
            }
        }

        return $key;
    }

    public static function getBagQuantitiesByKey($bag_key)
    {
        $skus = DB::table('bag_sku')
            ->select("sku_sku", "quantity", "key", "id")
            ->join("bags", 'bags.id', '=', 'bag_sku.bag_id')
            ->where("key", "=", $bag_key)
            ->get()
            ->keyBy("sku_sku");


        return [
            "key"   => $bag_key,
            "skus"  => $skus->map(function ($bag_sku) {
                return $bag_sku->quantity;
            }),
            "total" => $skus->sum("quantity")
        ];
    }

    public function inBag(Sku $sku)
    {
        return $this->skus()->where([ "sku" => $sku->sku ])->get()->count() > 0;
    }

    public function getProducts()
    {
        return Product::with("skus")->FromBag($this)->get();
    }

    public function getProductsIds()
    {
        return $this->getProducts()->map(function ($product) {
            return $product->id;
        });
    }

    public function getBagTotalsAttribute()
    {
        $totals = [
            "items"                     => 0,
            "price_with_discounts"      => 0.0,
            "local_shipping_rate"       => 0.0,
            "national_shipping_rate"    => 0.0,
        ];

        $is_active = $this->is_active;

        foreach ($this->skus as $sku_in_bag) {
            $totals[ "items" ]                      += $sku_in_bag->pivot->quantity;
            $totals[ "price_with_discounts" ]       += $sku_in_bag->pivot->quantity*($is_active ? $sku_in_bag->price_with_discount : $sku_in_bag->pivot_price_with_discount) ;
            $totals[ "local_shipping_rate" ]        += $sku_in_bag->pivot->quantity*($is_active ? $sku_in_bag->local_shipping_rate : $sku_in_bag->pivot->shipping_rate);
            $totals[ "national_shipping_rate" ]     += $sku_in_bag->pivot->quantity*($is_active ? $sku_in_bag->national_shipping_rate : $sku_in_bag->pivot->shipping_rate);
        }

        return $totals;
    }

    public function setShippingRate($local_shipping_rate)
    {
        $this->local_shipping_rate = $local_shipping_rate ? true : false;
    }

    public function getItemsForConekta()
    {
        return $this->skus->load(
                "product",
                "product.languages"
            )->map(function ($sku) {
                return $sku->conektaMap();
            })->toArray();
    }

    public function getItemsForPaypal()
    {
        return $this->skus->load(
                "product",
                "product.languages"
            )->map(function ($sku) {
                return $sku->paypalMap();
            })->toArray();
    }

    public function updateBagShipping(array $args, array $address)
    {
        $bag_shipping = $this->bagShipping;

        if (!$bag_shipping) {
            $bag_shipping = new BagShipping;
            $bag_shipping->bag_id = $this->id;
        }

        foreach ($args as $key => $value) {
            $bag_shipping->$key = $value;
        }

        if (!$bag_shipping->save()) {
            return false;
        }

        return $bag_shipping->updateAddressToUse($address, "shipping");
    }

    public function updateBagSku($in_ZMVM)
    {
        foreach ($this->skus as $sku) {
            $attributes = [
                'price'         => $sku->price,
                'shipping_rate' => 0,
                'discount'      => $sku->discount,
            ];

            if (!$this->bagType->event) {
                $attributes['shipping_rate'] = $in_ZMVM ? $sku->local_shipping_rate : $sku->national_shipping_rate;
            }

            $this->skus()->updateExistingPivot($sku->sku, $attributes);
        }

        return true;
    }

    public function updateBagUser($args)
    {
        if (!$this->bagUser) {
            return false;
        }

        foreach ($args as $key => $value) {
            $this->bagUser->$key = $value;
        }

        return $this->bagUser->save();
    }

    public function saveCharge($charge, array $totals)
    {
        $responce = [
            "error"         => null,
            "bag_payment"   => null
        ];

        $extra_info = [
            "print_message_cost"    => ($totals["print_message"] ?? 0.0)
        ];

        if ($charge->payment_method->type == "spei") {
            $extra_info["bank"] = $charge->payment_method->bank;
            $extra_info["clabe"] = $charge->payment_method->clabe;
        }


		$total_paid = array_sum($totals);

        $bag_payment_args = [
            'bag_id'            => $this->id,
            'payable_id'        => $charge->id,
            'payable_type'      => ($total_paid > 0 ? ( strpos($charge->payment_method->object, 'paypal') !== false ? "" : "conekta ") : "nice_to_have ").$charge->payment_method->object." ".$charge->payment_method->type,
            'payable_status'    => $charge->status,
            'currency'          => 1.00,
            'currency_type'     => "MXN",
            'total'             => $total_paid - ($totals["credit"] ?? 0.0),
			'total_credit'		=> -($totals["credit"] ?? 0.0) ,
            'paid_at'           => $charge->status == "paid" ? date("Y-m-d H:i:s") : null,
            'extra_info'        => $extra_info,
        ];

        $bag_payment = $this->bagPayment;
        if (!$bag_payment) {
            $bag_payment = BagPayment::create($bag_payment_args);

            if (!$bag_payment) {
                $responce["error"] = "El pago no pudo ser salvado.";
                return $responce;
            }
        } else {
            foreach ($bag_payment_args as $key => $bag_payment_arg) {
                $bag_payment->$key = $bag_payment_arg;
            }

            if (!$bag_payment->save()) {
                $responce["error"] = "El pago no pudo ser salvado.";
                return $responce;
            }
        }
        $responce["bag_payment"] = $bag_payment;
        return $responce;
    }

    public function saveShipping(array $input, array $totals)
    {
        $responce = [
            "error"         => null,
            "bag_shipping"   => null
        ];


        $address = Address::Create($input["address"]) ;

        if (!$address) {
            $responce["error"] = "La dirección de envío no pudo ser guardada.";
            return $responce;
        }

        $bag_shipping_args = [
            'bag_id'        => $this->id,
            'info'          => 'nice-to-have',
            'rate'          => $totals["shipping_rate"],
            'method'        => 'estandar',
            'address_id'    => $address->id,
            'tracking_code' => "",
        ];

        $bag_shipping = $this->bagShipping;

        if (!$bag_shipping) {
            $bag_shipping = BagShipping::create($bag_shipping_args);

            if (!$bag_shipping) {
                $responce["error"] = "El envío no pudo ser salvado.";
                return $responce;
            }
        } else {
            foreach ($bag_shipping_args as $key => $bag_shipping_arg) {
                $bag_shipping->$key = $bag_shipping_arg;
            }

            if (!$bag_shipping->save()) {
                $responce["error"] = "El envío no pudo ser salvado.";
                return $responce;
            }
        }

        $responce["bag_shipping"] = $bag_shipping;
        return $responce;
    }

    public function saveDiscount(array $input, array $totals)
    {
        $response = [
            "error"          => null,
            "bag_discount"   => null
        ];

        $discount = DiscountCode::where('code', $input['discount_code'])->with('discountCodeType')->first();

        $amount = 0;

        if ($discount->discountCodeType->percent && !$discount->discountCodeType->shipment && !$discount->discountCodeType->value) {
            $amount = ($totals['shipping_rate'] + $totals['subtotal']+ (isset($totals['print_message']) ? $totals['print_message'] : 0 ) )*($discount->value/100);
        }elseif (!$discount->discountCodeType->percent && $discount->discountCodeType->shipment && !$discount->discountCodeType->value) {
            $amount = $totals['shipping_rate'];
        }elseif (!$discount->discountCodeType->percent && !$discount->discountCodeType->shipment && $discount->discountCodeType->value) {
            $amount = $discount->value;
        }

        if ($this->bagDiscount) {
            $this->bagDiscount()->delete();
        }

        $bag_discount = $this->bagDiscount()->create([
            'discount_code_id'  => $discount->id,
            'amount'            => $amount
        ]);

        if (!$bag_discount) {
            $responce["error"] = "El descuento no pudo ser salvado.";
            return $responce;
        }

        $response['bag_discount'] = $this->bagDiscount;

        return $response;
    }

    public function saveBagUser(array $input, User $user)
    {
        $responce = [
            "error"         => null,
            "bag_user"      => null
        ];

        $user_args              = [
            "accept_terms"  => $input["accept_terms"],
            "name"          => $user->full_name ,
            "email"         => $user->email,
            "phone"         => $user->phone,
            "info"          => '',
        ];

        if ($this->bagType->register_user) {
            $user_args['info'] = [
                'email_friend'  => $input['email_friend'],
            ];
        }


        if (!$this->updateBagUser($user_args)) {
            $responce["error"] = "La información del usuario en la bolsa no pudo ser actualizada.";
            return $responce;
        };

        $responce["bag_user"] = $this->bagUser;

        return $responce;
    }

    public function saveBagSku(bool $in_ZMVM)
    {
        $responce = [
            "error"         => null,
            "bag_sku"       => null,
        ];

        if (!$this->updateBagSku($in_ZMVM)) {
            $responce["error"] = "La información de los skus en la bolsa no pudo ser actualizada.";
            return $responce;
        }

        $responce["bag_sku"] = $this->skus;

        return $responce;
    }

    public function getPresentUrl()
    {
        if (!$this->bagType->event && !$this->print_message && !$this->bagShipping && !$this->bagShipping->address && !$this->bagShipping->address->email) {
            return null;
        }

        return route('client::presents.show', [ 'present_bag' => $this->key, 'token' => cltvoMailEncode($this->bagShipping->address->email) ]);
    }

    public function getThankYouPageUrlAttribute()
    {
        return route('user::bag.thankyou-page.show', [ $this->bagUser->user->name  , $this->key]);
    }

    public function getThankYouPageBillingUrlAttribute()
    {
        return route('user::bag.thankyou-page.billing:get', [$this->bagUser->user->name , $this->key]);
    }

    public function updateProtectedBag()
    {
        $responce = [
            "error"                 => null,
            "protected_bag_skus"    => null,
        ];

        $protected_bag = $this->getProtectedBagForThisEvent();

        if (!$protected_bag) {
            $responce["error"] = "Esta bolsa no tiene ningun evento con bolsa protegida asociada.";
            return $responce;
        }

        $update =   DB::table('bag_sku')
                    ->insert(
                        DB::table('bag_sku')
                            ->where('bag_id', $this->id)
                            ->get()
                            ->map(function ($bag_sku) use ($protected_bag) {
                                $new_bag_sku['sku_sku']         = $bag_sku->sku_sku;
                                $new_bag_sku['bag_id']          = $protected_bag->id;
                                $new_bag_sku['parent_bag_id']   = $bag_sku->bag_id;
                                $new_bag_sku['quantity']        = $bag_sku->quantity;
                                $new_bag_sku['price']           = $bag_sku->price;
                                $new_bag_sku['shipping_rate']   = $bag_sku->shipping_rate;
                                $new_bag_sku['discount']        = $bag_sku->discount;
                                $new_bag_sku['created_at']      = $new_bag_sku['updated_at'] = date('Y-m-d H:i:s');
                                return $new_bag_sku;
                            })
                            ->toArray()
                        );

        if (!$update) {
            $responce["error"] = "Ocurrió un error al agregar los skus a la bolsa protegida del evento.";
            return $responce;
        }

        $responce["protected_bag_skus"] = $update;

        return $responce;
    }

    public function getErrorForNotPublicPoducts()
    {
        $errors = [];

        foreach ($this->skus as $bag_sku) {
            if (!$bag_sku->product->is_publish) {
                $this->skus()->detach($bag_sku);
                $errors[] = $bag_sku->product->title . ': ' . trans('checkout.errors.not_available');
            }
        }

        return $errors;
    }

    public function getEditBagUrlAttribute()
    {
        return route('admin::bags.edit', $this->key);
    }

    public function hasShipping()
    {
        return ($this->bagType->event && $this->bagType->special && !$this->bagType->protected) || (!$this->bagType->event && !$this->bagType->special && !$this->bagType->protected);
    }

    public function getRedisPaypalKeyAttribute()
    {
        return "nth:paypal:bag:".$this->key;
    }

}
