<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

class EventStatus extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_statuses';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug','label','active','publish'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'active'    => "boolean",
        'publish'   => "boolean",
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "created_at",
        "updated_at",
    ];

    public function events()
    {
        return $this->hasMany(Event::class);
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

    public static function getPublish()
    {
        return static::getBySlug("publicado");
    }

    public static function getFinish()
    {
        return static::getBySlug("finalizado");
    }
}
