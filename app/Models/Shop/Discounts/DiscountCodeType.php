<?php

namespace App\Models\Shop\Discounts;

use Illuminate\Database\Eloquent\Model;

class DiscountCodeType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'discount_codes_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'name',
        'label',
        'percent',
        'shipment',
        'value'
    ];

    public function discountCodes()
    {
        return $this->hasMany(DiscountCode::class);
    }

    public function scopePercent($query)
    {
        return $query->where(['percent' => true]);
    }

    public function scopeFreeShipment($query)
    {
        return $query->where(['shipment' => true]);
    }

    public function scopeValue($query)
    {
        return $query->where(['value' => true]);
    }
}