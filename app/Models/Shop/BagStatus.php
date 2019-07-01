<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

class BagStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bag_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'label',
        'active',
        'paid',
        'cancel'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'active'    => "boolean",
        'paid'     => "boolean",
        'cancel'   => "boolean",
    ];

    public function bags()
    {
        return $this->hasMany(Bag::class);
    }

    public function scopeBySlug($query,$status_slug)
    {
        return $query->where([
            'slug' => $status_slug
        ]);
    }

    public static function getBySlug($slug)
    {
        return static::BySlug($slug)->first();
    }

    public static function getActiveStatus()
    {
        return static::getBySlug("activo");
    }

    public static function getStatusPaid()
    {
        return static::getBySlug("pagado");
    }

    public static function getStatusPendingPayment()
    {
        return static::getBySlug("pago-pendiente");
    }

    public static function getStatusCanceled()
    {
        return static::getBySlug("cancelado");
    }

    public static function getStatusExpired()
    {
        return static::getBySlug("expirado");
    }
}
