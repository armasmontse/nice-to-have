<?php
namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

use App\Models\Traits\PhotoableTrait;
use App\Models\Traits\AddressableTrait;
use App\Models\Traits\UniqueSlugTrait;

use App\User;

use Carbon\Carbon;

use App\Setting;

use App\Models\Shop\Bag;
use App\Models\Shop\BagStatus;
use App\Models\Shop\BagType;

use App\Models\Address\Country;

use DB;

use App\Models\Events\CashOut;
use App\Models\Events\CashOutStatus;

use stdClass;

class Event extends Model
{
    use PhotoableTrait;
    use AddressableTrait;
    use UniqueSlugTrait;

    const COOKIE_TIME = 7*60*24;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'events';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'event_language';


    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'user_id',
        'key',

        'name',
        'slug',

        'feted_names',
        "description",

        "date",
        "timezone",

        'accept',
        'exclusive',

        'event_status_id',

        'typeable_id',
        'typeable_type'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'accept'            => 'boolean',
        'exclusive'         => 'boolean',
        'user_id'           => 'integer',
        'event_status_id'   => 'integer',
        'typeable_id'       => 'integer',
        'date'              => 'date'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'utc_date',
        'template_view',
        'thumbnail_image',
        // 'label',
        // 'title',
        // 'description',
        'public_url',
        'perfil_url',
        'shop_url',
        'template_is_publish',
        'close_empty_bag'
        // // 'es',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
        "user",
        "user_id",
        "typeable_type",
        // "typeable",
        "typeable_id",
        "eventStatus",
        // "eventTemplate",
        "event_status_id",
        "template_view",
        // "close_empty_bag",
        "exclusive",
        "accept",
    ];


    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function eventStatus()
    {
        return $this->belongsTo(EventStatus::class);
    }

    public function typeable()
    {
        return $this->morphTo();
    }

    public function eventTemplate()
    {
        return $this->hasOne(EventTemplate::class);
    }

    public function cashOuts()
    {
        return $this->hasMany(CashOut::class);
    }

    public function chargebacks()
    {
        return $this->hasMany(Chargeback::class);
    }

    public function bags()
    {
        return $this->hasMany(Bag::class);
    }

    public function getUtcDateAttribute()
    {
        return (new Carbon($this->attributes['date'], $this->attributes['timezone']))->setTimezone('UTC');
    }

    public function getTemplateViewAttribute()
    {
        $template = $this->eventTemplate;

        if (!$template) {
            return null;
        }
        return $template->template_view;
    }

    public function getThumbnailImageAttribute()
    {
        $template = $this->eventTemplate;

        if (!$template) {
            return new stdClass;
        }
        return $template->thumbnail_image;
    }

    public function getTemplateIsPublishAttribute()
    {
        return $this->eventTemplate && $this->eventTemplate->publish;
    }

    public function getIsDraftAttribute()
    {
        return $this->eventStatus->active && !$this->eventStatus->publish;
    }

    public function getIsPublishAttribute()
    {
        return $this->eventStatus->active && $this->eventStatus->publish;
    }

    public function getIsFinishAttribute()
    {
        return !$this->eventStatus->active && $this->eventStatus->publish;
    }

    public function getInTimeAttribute()
    {
        return $this->expiration_date->setTimezone('UTC')->gte(Carbon::now()->setTimezone('UTC'));
    }

    public function getExpirationDateAttribute()
    {
        $event_expiration = Setting::getEventExpiration();
        return $this->date->addMonths($event_expiration);
    }

    public function getTypeLabelAttribute()
    {
        $typeable = $this->typeable;
        return $typeable->object_type == "subtype" ? $typeable->type_label."/".$typeable->label : $typeable->label;
    }

    public function getProtectedBagValueAttribute()
    {
        $protected_bag = $this->getEventProtectedBag();

        return $protected_bag ? $protected_bag->skus->sum(function($sku){
            return $sku->pivot_price_with_discount*$sku->pivot->quantity;
        }) : 0.0;
    }

    public function getCurrentProtectedBagValueAttribute()
    {
        return $this->protected_bag_value - $this->chargebacks_totals ;
    }

    public function getCurrentTotalAttribute()
    {
        $retired_bag = $this->bags()->paid()->special()->notProtected()->get()->first();

        $retired_bag_amount = !is_null($retired_bag) && !is_null($retired_bag->bagPayment) ? $retired_bag->bagPayment->total_credit : 0.00;

        return $this->current_protected_bag_value - $this->cashouts_totals - $retired_bag_amount;
    }

    public function getCurrentCashoutsMaxAttribute()
    {
        $checkout_min = Setting::getCheckoutMinPercentage();

        if ($this->current_protected_bag_value <= 0) {
            return 0.0;
        }

        return (1-$checkout_min/100)*($this->current_protected_bag_value) - $this->cashouts_totals;
    }

    public function getCurrentCheckoutMinAttribute()
    {
        $checkout_min = Setting::getCheckoutMinPercentage();

        if ($this->current_protected_bag_value <= 0) {
            return -($this->current_protected_bag_value - $this->cashouts_totals);
        }

        return ($checkout_min/100)*($this->current_protected_bag_value); // falta integrar setting de porcentaje
    }

    public function getChargebacksTotalsAttribute()
    {
        $chargeback_total = 0;

        foreach ($this->chargebacks as $chargeback) {
            if ($chargeback->revert) {
                $chargeback_total -= $chargeback->amount;
            } else {
                if ($chargeback->bag) {
                    $chargeback_total += $chargeback->bag->bag_totals['price_with_discounts'];
                } else {
                    $chargeback_total += $chargeback->amount;
                }
            }
        }

        return $chargeback_total;
    }

    public function getCashoutsTotalsAttribute()
    {
        return $this->cashOuts()->applied()->get()->sum('total');
    }

    public function getNotCanceledCashOutsAttribute()
    {
        return $this->cashOuts()->whereHas('cashOutStatus', function ($q) {
            $q->notCanceled();
        })->get();
    }

    public function getCloseEmptyBagAttribute()
    {
        $close_bag = $this->getCloseBag();
        return !$close_bag ? false : $this->current_checkout_min == 0.0 && $close_bag->skus->isEmpty();
    }

    public function getCurrentFeePercentageAttribute()
    {
        $fee_values = Setting::getCashOutFeesPercentages();
        return $this->exclusive ? $fee_values["exclusive"] :  $fee_values["not_exclusive"];
    }

    public function getPublicUrlAttribute()
    {
        if (env('CLTVO_DEV_MODE') && env('APP_DEBUG')) {
            return route('client::events-alt.show', $this->slug);
        }

        return str_replace('https', 'http', route("client::events.show", $this->slug));
    }

    public function getShopUrlAttribute()
    {
        return route("client::events.shop", $this->slug) ;
    }

    public function getPerfilUrlAttribute()
    {
        if (!$this->is_finish) {
            return route("user::events.profile", [$this->user->name, $this->slug]) ;
        }

        return route("user::events.gifts", [$this->user->name, $this->slug]) ;
    }

    public function getCashOutsUrlAttribute()
    {
        return route("user::events.cash-outs.index", [$this->user->name,$this->slug]) ;
    }

    public function getBagUrlAttribute()
    {
        return route("user::events.bag.index", [$this->user->name,$this->slug]) ;
    }

    public function getInZvmAttribute()
    {
        $address = $this->getMainAddress();
        if (!$address) {
            return false;
        }
        return Country::inZMVM($address->state, $address->street2);
    }

    public function getIsCloseBagActiveAttribute()
    {
        $close_bag = $this->getCloseBag();
        return !$close_bag ? false : $close_bag->is_active;
    }

    public function scopeOpen($query)
    {
        return $query->with("eventStatus")
            ->whereHas("eventStatus", function ($q) {
                return $q->where([
                    "active"    => true,
                    "publish"   => true,
                ]);
            });
    }

    public function getEventProtectedBag()
    {
        return $this->bags()->actives()->eventProtected()->first();
    }

    public function getCloseBag()
    {
        return $this->bags()->eventSpecialNotProtected()->first();
    }

    public function getEventProtectedBagProducts()
    {
        $protected_bag = $this->getEventProtectedBag();
        return $protected_bag ? $protected_bag->getProducts() : collect([]);
    }

    public static function generateUniqueKey($name, $date)
    {
        $explode_name = explode("-", str_slug(trim($name)));
        $explode_date = explode("-", str_slug(trim($date)));

        $key = '';

        foreach ($explode_name as $trozo) {
            $key .= substr($trozo, 0, 2);
        }

        $key = str_pad($key, 6, chr(rand(ord('a'), ord('z'))), STR_PAD_LEFT);

        $key = substr($key, 0, 6);

        foreach ($explode_date as $trozo) {
            $key .= substr($trozo, 0, 2);
        }

        $unique = false;

        while (!$unique) {

            $events = static::where(["key" => $key])->get();

            if ($events->count() == 0) {
                $unique = true;
            } else {
                $key = substr(chr(rand(ord('a'), ord('z'))).$key, 0, 12);
            }

        }

        return $key;
    }

    public static function generateUniqueSlug($name)
    {
        $slug = str_slug(trim($name));

        $slug_is_not_unique = true;
        $gluter = "-";
        while ($slug_is_not_unique) {
            if (!static::where(["slug" => $slug])->get()->count() > 0) {
                $slug_is_not_unique = false;
            } else {
                $slug.= $gluter.rand(0, 9);
            }
            $gluter = "";
        }

        return $slug;
    }

    public function closeEvent()
    {
        $response = [
            'type'  => '',
            'message'  => '',
        ];

        $pending_cashouts = $this->cashOuts()->pending()->get();

        if (!$pending_cashouts->isEmpty()) {
            $response['type'] = 'error';
            $response['message'] = 'La bolsa tiene retiros en efectivo activos.';
            return $response;
        }

        // Se obtienen las bolsas de este evento que no están pagadas para cancelarlas
        $bags_not_paid = $this->bags()->eventNotSpecialNotProtected()->notPaid()->inActives()->get();

        // Si hay mas de una bolsa pagada
        if ($bags_not_paid->count() > 0) {

            // Se obtiene el status de bolsa cancelado
            $expired_status = BagStatus::getStatusExpired();

            // Si no existe el status cancelado se envía error.
            if (!$expired_status) {
                $response['type'] = 'error';
                $response['message'] = 'El status de bolsa cancelado no existe.';
                return $response;
            }

            // Recorremos sobre la colección de bolsas no pagadas para cancelarlas
            foreach ($bags_not_paid as $bag_not_paid) {

                // Conekta cancelar compra.
                $conekta_cancel = true;

                // Si se canceló la bolsa en conekta entonces podemos cancelarla nosotros
                if ($conekta_cancel) {

                    // Cancelamos la bolsa
                    if (!$bag_not_paid->bagStatus()->associate($expired_status)->save()) {
                        $response['type'] = 'error';
                        $response['message'] = 'No se pudo expirar la bolsa ' . $bag_not_paid->key . '.';
                        return $response;
                    }
                }
            }
        }

        // Obtenemos la bolsa protegida del evento.
        $protected_bag = $this->getEventProtectedBag();

        if (!$protected_bag) {
            $protected_type = BagType::getProtectedSpecialEventType();

            if (!$protected_type) {
                $response['type'] = 'error';
                $response['message'] = 'El tipo de bolsa mesa de regalos no existe.';
                return $response;
            }

            $protected_bag = Bag::createBag($this->user, $protected_type, $this);

            if (!$protected_bag) {
                $response['type'] = 'error';
                $response['message'] = 'No se pudo crear la bolsa mesa de regalos para el evento ' . $this->key . '.';
                return $response;
            }
        }

        // Obtenemos la bolsa retirar_mesa_de_regalos.
        $remove_bag = $this->bags()->eventSpecialNotProtected()->actives()->first();

        // Se revisa si no existe una bolsa de retirar mesa de regalos.
        if (!$remove_bag) {

            // Obtener el Tipo de bolsa que sea retirar mesa de regalos
            $type = BagType::getNotProtectedSpecialEventType();

            if (!$type) {
                $response['type'] = 'error';
                $response['message'] = 'El tipo de bolsa retirar mesa de regalos no existe.';
                return $response;
            }

            // Si no existe una bolsa de retirar mesa de regalos se crea una para el evento.
            $remove_bag = Bag::createBag($this->user, $type, $this);

            if (!$remove_bag) {
                $response['type'] = 'error';
                $response['message'] = 'No se pudo crear la bolsa retirar mesa de regalos para el evento ' . $this->key . '.';
                return $response;
            }
        }

        // Clonamos los productos de la bolsa protegida en la bolsa de retirar mesa de regalos.
        $update = DB::table('bag_sku')
                  ->insert(
                      DB::table('bag_sku')
                      ->select(DB::raw('sku_sku, SUM(quantity) as sku_quantity'))
                      ->where('bag_id', $protected_bag->id)
                      ->groupBy('sku_sku')
                      ->get()
                      ->map(function ($bag_sku) use ($remove_bag) {
                          $new_bag_sku['sku_sku']         = $bag_sku->sku_sku;
                          $new_bag_sku['bag_id']          = $remove_bag->id;
                          $new_bag_sku['quantity']        = $bag_sku->sku_quantity;
                          $new_bag_sku['created_at']      = $new_bag_sku['updated_at'] = date('Y-m-d H:i:s');
                          return $new_bag_sku;
                      })
                      ->toArray()
                  );

        if (!$update) {
            $response['type'] = 'error';
            $response['message'] = 'No se puedo clonar la bolsa mesa de regalos a retirar mesa de regalos del evento ' . $this->key . '.';
            return $response;
        }

        // Obtenemos el status de los eventos cancelado
        $finished_status = EventStatus::getFinish();

        if (!$finished_status) {
            $response['type'] = 'error';
            $response['message'] = 'El status de evento finalizado no existe.';
            return $response;
        }

        // Se cambia el status del evento
        if (!$this->eventStatus()->associate($finished_status)->save()) {
            $response['type'] = 'error';
            $response['message'] = 'No se pudo finalizar el evento ' . $this->key . '.';
            return $response;
        }

        $response['type'] = 'success';
        $response['message'] = 'El evento ' . $this->key . ' ha sido cerrado exitosamente.';

        return $response;
    }

    public function movements()
    {
        $movements = [];

        $chargebacks = $this->chargebacks;

        foreach ($chargebacks as $chargeback) {
            $movements[] = [
                'date'      => $chargeback->created_at,
                'concept'   => 'Cancelación bolsa #'.$chargeback->bag->key,
                'amount'    => $chargeback->bag->bag_totals['price_with_discounts'],
                'revert'    => false,
                'balance'   => 0.00,
            ];
        }

        $cash_outs = $this->cashOuts()->applied()->get();

        foreach ($cash_outs as $cash_out) {
            $movements[] = [
                'date'      => $cash_out->created_at,
                'concept'   => 'Retiro efectivo',
                'amount'    => $cash_out->total_out,
                'revert'    => false,
                'balance'   => 0.00,
            ];
            $movements[] = [
                'date'      => $cash_out->created_at->addSecond(),
                'concept'   => 'Comisión por retiro efectivo',
                'amount'    => $cash_out->total - $cash_out->total_out,
                'revert'    => false,
                'balance'   => 0.00,
            ];
        }

        // Carritos que no sean especiales y no protegido
        $payed_bags = $this->bags()->paid()->notProtected()->notSpecial()->get();

        foreach ($payed_bags as $payed_bag) {
            $movements[] = [
                'date'      => $payed_bag->purshased_at,
                'concept'   => 'Regalos recibidos bolsa #'.$payed_bag->key,
                'amount'    => $payed_bag->bag_totals["price_with_discounts"],
                'revert'    => true,
                'balance'   => 0.00,
            ];
        }

        // Carritos que sea especial y no protegido
        $payed_retired_bag = $this->bags()->paid()->notProtected()->special()->get()->first();

        if ($payed_retired_bag) {
            $movements[] = [
                'date'      => $payed_retired_bag->purshased_at,
                'concept'   => 'Bolsa #' . $payed_retired_bag->key . ' pagada con saldo',
                'amount'    => $payed_retired_bag->bagPayment->total_credit,
                'revert'    => false,
                'balance'   => 0.00,
            ];
        }

        array_multisort(array_map(function ($element) {
            return $element['date'];
        }, $movements), SORT_ASC, $movements);

        $total = 0;

        foreach ($movements as &$movement) {
            if ($movement['revert']) {
                $total += $movement['amount'];
            } else {
                $total -= $movement['amount'];
            }
            $movement['balance'] = $total;
        }

        return $movements;
    }

    public function saveCashOut($bank_account_id, $amount)
    {
        $responce = [
            "error"      => null,
            "cash_out"   => null
        ];

        $required_status = CashOutStatus::required()->first();


        $cash_out = CashOut::create([
            'event_id'                => $this->id,
            'cash_out_status_id'    => $required_status->id,

            'info'                    => 'restante flor aqui',

            'bank_account_id'        => $bank_account_id,
            'total'                    => $amount,
            'total_out'                => $amount*(1-$this->current_fee_percentage/100)
        ]);

        if (!$cash_out) {
            $responce["error"] = "El cashout no pudo ser salvado.";
            return $responce;
        }

        $responce["cash_out"] = $cash_out;
        return $responce;
    }

    public function getBagsCount()
    {
        return $this->bags()->paid()->whereHas('bagType', function ($query) {
            return $query->where([
                ['event', '=', true],
                ['special', '=', false],
                ['protected', '=', false],
            ]);
        })->get()->count();
    }
}
