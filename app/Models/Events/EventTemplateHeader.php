<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

class EventTemplateHeader extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_template_headers';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'view'
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
    
    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
    ];

    public function eventTemplates()
    {
        return $this->hasMany(EventTemplate::class);
    }

}
