<?php

namespace App\Models\Users;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\User;

class Card extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cards';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'number','type','conekta_token','user_id'
    ];


    protected $casts = [
        'id'        => 'integer',
        'user_id'   => 'integer',
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        'conekta_token',
        "created_at",
        "updated_at",
        "deleted_at"
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'display_number',
    ];


    /**
     * Trae los permisos del role
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function getCardProvider()
    {
        $card_providers = static::getCardProviderMap();
        return isset($card_providers[$this->type]) ? $card_providers[$this->type] : null;
    }

    public function getDisplayNumberAttribute()
    {
        $card_provider = $this->getCardProvider();
        if ( $card_provider && $card_provider["length"] == 15 ) {
            return str_pad($this->number,17,"XXXX-XXXXXX-", STR_PAD_LEFT );
        }

        return str_pad($this->number,19,"XXXX-", STR_PAD_LEFT );
    }

    public static function getCardProviderMap()
    {

        $card_providers= [
            "V" => [
                'card_provider_key'  => "V",
                'card_provider'      => "Visa",
                'iin_ranges'    => [4],
                'length'        => 16
            ],
            "M" => [
                'card_provider_key'  => "M",
                'card_provider'      => "MasterCard",
                'iin_ranges'    => [5]+range(2221,2720),
                'length'        => 16
            ],
            "A" => [
                'card_provider_key'  => "A",
                'card_provider'      => "American Express",
                'iin_ranges'    => [34,37],
                'length'        => 15
            ]
        ];
        return $card_providers;
    }
}
