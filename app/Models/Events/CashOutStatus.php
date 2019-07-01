<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;
use App\Models\Events\CashOut;

class CashOutStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'cash_out_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'label',
        'apply',
        'cancel',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'slug'      => 'string',
        'label'     => 'string',
        'apply'     => 'boolean',
        'cancel'    => 'boolean',
    ];

    public function cashOuts()
    {
        return $this->hasMany(CashOut::class);
    }

    public function scopeRequired($query)
    {
        return $query->where([
            ['apply', '=', false],
            ['cancel', '=', false],
        ]);
    }

    public function scopeApplied($query)
    {
        return $query->where([
            ['apply', '=', true],
            ['cancel', '=', false],
        ]);
    }

    public function scopeCanceled($query)
    {
        return $query->where([
            ['apply', '=', false],
            ['cancel', '=', true],
        ]);
    }

	public function scopeNotCanceled($query)
	{
		return $query->where([
			['cancel', '=', false],
		]);
	}
}
