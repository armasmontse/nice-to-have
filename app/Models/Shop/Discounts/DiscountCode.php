<?php

namespace App\Models\Shop\Discounts;

use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Model;

use App\Models\Shop\Bag;

use Carbon\Carbon;

class DiscountCode extends Model
{
    use SoftDeletes;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'discount_codes';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'code',
        'description',
        'initial_date',
        'end_date',
        'value',
        'unique',
        'discount_code_type_id'
    ];

    /**
     * The attributes that should be mutated to dates.
     *
     * @var array
     */
    protected $dates = [
        'initial_date',
        'end_date',
        'deleted_at'
    ];

    /**
     * Regresa el tipo de código de descuento
     */
    public function discountCodeType()
    {
        return $this->belongsTo(DiscountCodeType::class);
    }

    public function bags()
    {
        return $this->belongsToMany(Bag::class, 'bag_discounts')->withPivot('amount')->withTimestamps();
    }

    /**
     * Si el descuento esta en su periodo de actividad
     * @return boolean en su periodo de actividad
     */
    public function getInTimeAttribute()
    {
        $Now = Carbon::Now();
        return $Now->gt($this->initial_date) && $Now->lt($this->end_date);
    }

    public function scopeByCode($query, $code)
    {
        return $query->where(['code' => $code]);
    }

    public function scopeInTime($query)
    {
        $today = date('Y-m-d');

        return $query->where([
            ['initial_date', '<=', $today],
            ['end_date', '>=', $today]
        ]);
    }

    public function getValueLabelAttribute()
    {
        if($this->discountCodeType->percent)
        {
            return $this->value . '%';
        }
        elseif($this->discountCodeType->value)
        {
            return '$' . $this->value . ' de crédito';
        }

        return 'Envío gratis';
    }
}
