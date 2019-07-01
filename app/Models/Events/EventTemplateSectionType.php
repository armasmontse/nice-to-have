<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

class EventTemplateSectionType extends Model
{
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_template_section_types';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'slug',
        'label',
        'rules',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'rules' => 'array',
    ];

    public function eventTemplateSections()
    {
        return $this->hasMany(EventTemplateSection::class);
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
}
