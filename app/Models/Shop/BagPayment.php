<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class BagPayment extends Model
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
    protected $table = 'bag_payments';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'bag_id',
        'paid_at',

        'payable_id',
        'payable_type',
        'payable_status',

        'currency',
        'currency_type',
        'total',
		'total_credit',

        'paid_at',
        'extra_info',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'bag_id'   => 'integer',
        'paid_at'  => 'date',

        'currency' => 'double',
        'total'    => 'double',

        'extra_info' => 'array'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'id',
		'payable_type_label'
    ];

    public function bag()
    {
        return $this->belongsTo(Bag::class);
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

	public function getPayableTypeLabelAttribute()
	{

		if (strpos( $this->payable_type,"card_payment" ) !== false) {
			return "Tarjeta";
		}
		if (strpos( $this->payable_type,"bank_transfer_payment" ) !== false) {
			return "SPEI";
		}

		if (strpos( $this->payable_type,"gift_table_payment" ) !== false) {
			return "Saldo";
		}

        if (strpos( $this->payable_type,"paypal" ) !== false) {
            return "Paypal";
        }

		return  $this->payable_type;
	}


}
