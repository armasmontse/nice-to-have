<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

use App\Models\Address\Address;

class BagShipping extends Model
{
    /**
     * [$primaryKey description]
     * @var string
     */
    protected $primaryKey = 'bag_id';

    /**
     * [$incrementing description]
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bag_shippings';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bag_id',
        'address_id',
        'info',
        'rate',
        'method',
        'tracking_code',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bag_id'        => 'integer',
        'address_id'    => 'integer',
        'rate'          => 'double',
        'method'        => 'string',
        'tracking_code' => 'string',
        // 'estafeta_guide'        => 'boolean',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'id',
    ];

    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }


    public function address()
    {
        return $this->belongsTo(Address::class);
    }


    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getIdAttribute()
    {
        return $this->attributes['bag_id'];
    }

}
