<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;

use App\Models\Traits\PhotoableTrait;

use stdClass;

class EventTemplateSection extends Model
{
    use PhotoableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'event_template_sections';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_template_id',
        'event_template_section_type_id',

        'order',
        'publish',
        'background_color',
        'title',
        'link',
        'html',
        'iframe',
        'content',
    ];

	public static $image_uses = [
		'thumbnail',
	];

	public static $image_galleries = [
	];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'event_template_id'                  => 'integer',
        'event_template_section_type_id'     => 'integer',

        'order'                              => 'integer',
        'publish'                            => "boolean",

        'content'                            => "array",
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'thumbnail_image',
    ];

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getThumbnailImageAttribute()
    {
        $photo = $this->getFirstPhotoTo(["use"=>"thumbnail"]);
        return $photo ? $photo : new stdClass;
    }


    public function eventTemplate()
    {
        return $this->belongsTo(EventTemplate::class,'event_template_id', 'event_id');
    }

    public function eventTemplateSectionType()
    {
        return $this->belongsTo(EventTemplateSectionType::class);
    }


}
