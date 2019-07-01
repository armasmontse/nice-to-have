<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

use App;
use App\Photo;
use App\Models\Traits\PhotoableTrait;

use stdClass;

class Setting extends Model
{

    use PhotoableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'settings';

    public $primaryKey  = 'key';

	const SITE_COPYS_ARRAY = [
        'create_event'      => [
			'phase_2',
			'phase_3',
			'phase_4',
			'phase_4_exclusiveness',
			'phase_5'
		],
        'event_profile'     => [
			'header',
			'web_design_invitation',
			'web_design_clarification',
			'activate_event',
			'close_event',
			'cancel_event',
			'cash_withdrawal',
			// 'shopping_cart',
			//'checkout_alert',
			'popup_event_activated',
			'popup_event_cancelled'
		],

		'web_event'         => [
			'header',
			'change_color',
			'new_section_instructions',
            'select_section_instructions',
			'publish_web_event',
		],

		'message_and_gifts' => [
			'gift_registry'
		],

		'cash_withdrawal'   => [
			'header',
			'instructions',
			'withdrawal_requested',
			'fees'
		],
        'event_bags'   => [
            'header',
			'popup_close_empty_bag'
        ],

        'event_checkout'    => [
            'alert_not_min',
        ],

		'checkout'          => [
			'event_send',
			'instructions',
			'note_instructions'
		],

		'thank_you_page'    => [
			'gratitude_alert',
			'ramaining_products'
		],

		'search'            => [
			'search_message',
			'without_results'
		],

		'shopping_carts'    => [
			'personal_shopping_cart_empty',
			'event_shopping_cart_empty',
			'delete_product'
		]
    ];

	public static $image_uses = [
        'thumbnail',
    ];

    public static $image_galleries = [
    ];

    /**
     * [$incrementing description]
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $photo_table = 'photo_setting';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'key','value'
    ];

    protected $casts = [
        'value' => 'array',
    ];

    protected $attributes = [
        'value' => '',
    ];

    protected $appends = [
        'thumbnail_image',
    ];

    public function getThumbnailImageAttribute()
    {
        $photo = $this->getFirstPhotoTo(['use' => 'thumbnail']);
        return $photo ? $photo : new stdClass;
    }

    public function photos()
    {
        return $this->belongsToMany(Photo::class,$this->photo_table,"setting_key","photo_id")->withPivot($this->photoable)->withTimestamps();
    }

    /**
    * Scope a query to get element by key
    *
    * @return \Illuminate\Database\Eloquent\Builder
    */
    public function scopeKey($query, $key)
    {
        return $query->where('key', $key)->get();
    }

    public static function getSetting($key )
    {
        $setting = static::key($key)->first();

        if (!$setting) {
            $setting = self::create([ 'key' => $key] );
        }

        return $setting;
    }

    public static function getDescription($iso = null)
    {
        return self::getSetting('description');
    }

    /**
    * Get the Blog Link
    *
    * @return array[] with url,
    */
    public static function getBlog()
    {
        return self::getSetting('blog')->value;
    }

    /**
    * Get the Social Networks Link
    *
    * @return array[] with urls,
    */
    public static function getSocialNetworks()
    {
        return self::getSetting('social')->value;
    }

    public static function getSpecificSocialNetwork( $sn_name )
    {
        return array_get(self::getSocialNetworks(), $sn_name);
    }

    /**
    * Get the Authentication values
    *
    * @return array[] with urls,
    */
    public static function getAuthentication()
    {
        return self::getSetting('authentication')->value;
    }

    public static function getAuthenticationCopy($key, $iso = null)
    {
        $iso = is_null($iso) ? (session('lang') ? session('lang') : App::getLocale()) : $iso;

        $copys = self::getAuthentication();

        if (!$copys || !array_get($copys, $key . '.' . $iso))
        {
            return '';
        }
        return $copys[$key][$iso];
    }

    /**
    * Get the Copys values
    *
    * @return array[] with urls,
    */
    public static function getPagesCopys()
    {
        return self::getSetting('copys')->value;
    }

    public static function getSpecificCopy($key, $iso = null):string
    {
        $iso = is_null($iso) ? (session('lang') ? session('lang') : App::getLocale() ): $iso;

        $copys = self::getPagesCopys();

        if (!$copys || !array_get($copys, $key.'.'.$iso) ) {
            return '';
        }
        return $copys[$key][$iso];
    }

    /**
    * Get the Mail values
    *
    * @return array[] with urls,
    */
    public static function getMail()
    {
        return self::getSetting('mail')->value;
    }

    public static function getEmail($key):string
    {
        $mail = self::getMail();
        if (!$mail || !array_has($mail,$key) ) {
            return env('SEND_MAIL_AS');
        }
        return $mail[$key];
    }

    public static function getEmailCopy($key, $iso = null):string
    {
        $iso = is_null($iso) ? (session('lang') ? session('lang') : App::getLocale() ): $iso;
        $key = $key.'_copy';
        $mail = self::getMail();

        if (!$mail || !array_has($mail, $key.'.'.$iso) ) {
            return '';
        }

        return $mail[$key][$iso];
    }

    public static function getEmailGreeting($iso = null):string
    {
        $iso = is_null($iso) ? (session('lang') ? session('lang') : App::getLocale() ): $iso;
        $mail = self::getMail();

        if (!$mail || !array_has($mail, 'mail_greeting.'.$iso) ) {
            return '';
        }
        return $mail['mail_greeting'][$iso];
    }

    public static function getEmailFarewell($iso = null):string
    {
        $iso = is_null($iso) ? (session('lang') ? session('lang') : App::getLocale() ): $iso;

        $mail = self::getMail();
        if (!$mail || !array_has($mail, 'mail_farewell.'.$iso) ) {
            return '';
        }
        return $mail['mail_farewell'][$iso];
    }

    /**
    * Get the card with a present cost
    *
    * @return array[] with urls,
    */
    public static function getPrintMessageCost()
    {
        $result = isset(self::getSetting('card_cost')->value) ? self::getSetting('card_cost')->value : self::getDefaultCardCost();
        return floatval(  $result['cost'] )  ;
    }

	public static function getDefaultCardCost()
    {
        return [
            'cost'  =>  0,
        ];
    }

	/**
    * Get the card with a present cost
    *
    * @return array[] with urls,
    */
    public static function getCashoutMinAmount()
    {
        $result = isset(self::getSetting('cashout_min_amount')->value) ? self::getSetting('cashout_min_amount')->value : self::getDefaultCashoutMinAmount();
        return floatval(  $result['min_amount'] )  ;
    }

	public static function getDefaultCashoutMinAmount()
    {
        return [
            'min_amount'  =>  110,
        ];
    }

	/**
	* Get the cashout min percentage
	*
	* @return array[] with urls,
	*/
	public static function getCheckoutMinPercentage()
	{
		$result = isset(self::getSetting('checkout_min')->value) ? self::getSetting('checkout_min')->value : self::getDefaultCashoutMinPercentage();
		return floatval(  $result['percentage'] )  ;
	}

	public static function getDefaultCashoutMinPercentage()
    {
        return [
            'percentage'  =>  30,
        ];
    }

	/**
	* Get the cashout min percentage
	*
	* @return array[] with percentajes,
	*/
	public static function getCashOutFeesPercentages()
	{
		$percentages = collect( [
			"exclusive"		=> 5,
			"not_exclusive"	=> 7.5,
		]);

		$setting = self::getSetting('cash_out_fees')->value;

		return  $percentages->map(function($percentage,$key) use ($setting) {
			return floatval( array_get($setting, $key , $percentage ) );
		})->toArray();
	}

    /**
    * Get the Event expiration values
    *
    * @return array[] with urls,
    */
    public static function getEventExpiration():int
    {
        $result = isset(self::getSetting('event_expiration')->value) ? self::getSetting('event_expiration')->value : self::getDefaultEventExpiration();
        return $result['time'];
    }

    public static function getDefaultEventExpiration()
    {
        return [
            'time'  =>  3,
        ];
    }

    /**
    * Get the Shipment values
    *
    * @return array[] with urls,
    */
    public static function getShipment()
    {
        return self::getSetting('shipment')->value;
    }

    public static function getOriginZip()
    {
        $shipment = self::getShipment();
        if (!$shipment || !array_has($shipment,'origin-address') || !array_has($shipment,'origin-address.zip') ) {
            return env('ORIGIN_ZIP_CODE');
        }
        return $shipment['origin-address']['zip'];
    }

    public static function getPackageAverageWeight()
    {
        $shipment = self::getShipment();
        if (!$shipment || !array_has($shipment,'average-weight') ) {
            return env('PACKAGE_AVERAGE_WEIGHT');
        }
        return $shipment['average-weight'];
    }

    public static function getPackageMinimumGarments()
    {
        $shipment = self::getShipment();
        if (!$shipment || !array_has($shipment,'minimal-clothing') ) {
            return env('PACKAGE_MINIMUM_GARMENTS');
        }
        return $shipment['minimal-clothing'];
    }

    /**
    * Get the Exchange values
    *
    * @return array[] with urls,
    */
    public static function getExchange()
    {
        return self::getSetting('exchange_rate')->value;
    }

    public static function getDefaultExchange()
    {
        $exchange = static::getExchange();

        if ( is_array($exchange)  && array_has($exchange,'US') && array_has($exchange,'US.currency') && array_has($exchange,'US.exchange') ) {
            return $exchange['US']['exchange'];
        }

        return env('DEFAULT_EXCHANGE');
    }

    public static function getExchangeByIso($iso)
    {
        if ($iso == 'MX') {
            return 1;
        }

        $exchange = static::getExchange();

        if (is_array($exchange)  && array_has($exchange,$iso) && array_has($exchange,$iso.'.exchange') ) {
            return $exchange[$iso]['exchange'];
        }

        return static::getDefaultExchange();
    }

    public static function getExchangeByCurrency($currency)
    {
        if ($currency == 'MXN') {
            return 1;
        }

        $exchange = static::getExchange();

        foreach ($exchange as $value) {
            if ($value['currency'] == $currency) {
                return $value['exchange'];
            }
        }

        return static::getDefaultExchange();
    }

    /**
    * Get the Currency values
    *
    * @return array[] with urls,
    */
    public static function getDefaultCurrency()
    {
        $exchange = static::getExchange();

        if (is_array($exchange) && array_has($exchange,'US') && array_has($exchange,'US.currency') && array_has($exchange,'US.exchange') ) {
            return $exchange['US']['currency'];
        }

        return env('DEFAULT_CURRENCY');

    }

    public static function getCurrencyByIso($iso)
    {
        if ($iso == 'MX') {
            return 'MXN';
        }

        $exchange = static::getExchange();

        if (is_array($exchange) && array_has($exchange,$iso) && array_has($exchange,$iso.'.currency') ) {
            return $exchange[$iso]['currency'];
        }

        return static::getDefaultCurrency();
    }

    /**
    * Get Image setting
    *
    * @return object with photoable,
    */
    public static function getRegisterImage()
    {
        return self::getSetting('register_image');
    }

    /**
    * Get Image setting
    *
    * @return object with photoable,
    */
    public static function getLoginImage()
    {
        return self::getSetting('login_image');
    }

    /**
    * Get Image setting
    *
    * @return object with photoable,
    */
    public static function getEventRegisterImage()
    {
        return self::getSetting('event_register_image');
    }

    /**
    * Get Image setting
    *
    * @return object with photoable,
    */
    public static function getCheckoutRegisterImage()
    {
        return self::getSetting('checkout_register_image');
    }

    /**
    * Get Image setting
    *
    * @return object with photoable,
    */
    public static function getCreateEventImages()
    {
        return self::getSetting('create_event_images');
    }

    public static function getEventImageSearch()
    {
        return self::getSetting('event_image_search');
    }

}
