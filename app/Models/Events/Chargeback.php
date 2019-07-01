<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

use App\Models\Shop\Bag;

class Chargeback extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'chargebacks';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'bag_id',
        'info',
        'favour',
        'amount',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'event_id'   => "integer",
        'bag_id'     => "integer",
        'info'       => "string",
        'favour'     => "boolean",
        'amount'     => "double",
    ];

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function bag()
    {
        return $this->belongsTo(Bag::class);
    }

    public function scopeFavour($query)
    {
        return $query->where('revert', true);
    }

    public function scopeAgainst($query)
    {
        return $query->where('revert', false);
    }

}
