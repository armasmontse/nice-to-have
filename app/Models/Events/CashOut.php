<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;
use App\Models\Events\Event;
use App\Models\Events\CashOutStatus;
use App\Models\Users\BankAccount;
use App\Models\Traits\UpdatedAtTrait;

class CashOut extends Model
{
    use UpdatedAtTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cash_outs';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'total',
        'total_out',
        'info',
        'cash_out_status_id',
        'bank_account_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'event_id'              => 'integer',
        'total'                 => 'double',
        'total_out'             => 'double',
        'info'                  => 'string',
        'cash_out_status_id'    => 'integer',
        'bank_account_id'       => 'integer',
    ];

    protected $appends = [
        'fee',
        'fee_value',
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function cashOutStatus()
    {
        return $this->belongsTo(CashOutStatus::class);
    }

    public function bank_account()
    {
        return $this->belongsTo(BankAccount::class)->withTrashed();
    }

    public function scopeApplied($query)
    {
        return $query->whereHas('cashOutStatus', function($q){
            return $q->applied();
        });
    }

    public function scopePending($query)
    {
        return $query->whereHas('cashOutStatus', function($q){
            return $q->required();
        });
    }

    public function getFeeAttribute()
    {
        $fee = 100 - ( ($this->total_out * 100) / $this->total );

        return round($fee, 2);
    }

    public function getFeeValueAttribute()
    {
        $value = $this->total - $this->total_out;
        
        return round($value, 2);
    }

}
