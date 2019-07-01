<?php

namespace App\Models\Shop;

use Illuminate\Database\Eloquent\Model;

use App\Models\Events\Event;

class BagType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'bag_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'label',
        'event',
        'special',
        'protected',
        'register_user',
        'default_key'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'event'         => "boolean",
        'special'       => "boolean",
        'protected'     => "boolean",
        'register_user' => "boolean",
        'default_key'   => 'string'
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

    public function scopeSpecial($query)
    {
        return $query->where(["special"  => true]);
    }

    public function scopeNotSpecial($query, Event $event = null)
    {
        if (!$event) {
            $query = $query->where(["event"  => false ]);
        }
        return $query->where(["special"  => false ]);
    }

    public function scopeNotProtected($query)
    {
        return $query->where(["protected"  => false]);
    }

    public function scopeProtected($query)
    {
        return $query->where(["protected"  => true]);
    }

    public function scopeEvent($query)
    {
        return $query->where(["event"  => true]);
    }

    public function scopeNotEvent($query)
    {
        return $query->where(["event"  => false]);
    }

    // Retirar mesa de regalos.
    public static function getNotProtectedSpecialEventType()
    {
        return static::event()->special()->notProtected()->first();
    }

    // Mesa de regalos.
    public static function getProtectedSpecialEventType()
    {
        return static::event()->special()->protected()->first();
    }

    public static function getDefaultKeys(Event $event = null)
    {
        return static::NotSpecial($event)->NotProtected()->get()->keyBy("default_key");
    }
}
