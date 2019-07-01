<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

use App\Models\Shop\Discounts\DiscountCode;

class BagDiscount extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bag_discounts';

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
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bag_id',
        'discount_code_id',
        'amount'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bag_id'            => 'integer',
        'discount_code_id'  => 'integer',
        'amount'            => 'double'
    ];

    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }

    public function discountCode()
    {
        return $this->belongsTo(DiscountCode::class)->withTrashed();
    }
}