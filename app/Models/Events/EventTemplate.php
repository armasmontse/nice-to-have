<?php

namespace App\Models\Events;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\PhotoableTrait;

use App\Photo;

use stdClass;

class EventTemplate extends Model
{
    use PhotoableTrait;

    /**
     * [$primaryKey description]
     * @var string
     */
    protected $primaryKey = 'event_id';

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
    protected $table = 'event_templates';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'event_id',
        'event_template_header_id',

        'timer',
        'publish',

        'background_color',
        'image_background_color',
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
        'event_id'                  => 'integer',
        'event_template_header_id'  => 'integer',

        'timer'                     => "boolean",
        'publish'                   => "boolean",
    ];
    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'id',
        'template_view',
        'thumbnail_image',
        'event_template_header_id'
    ];

	public static $image_uses = [
        'thumbnail',
    ];

    public static $image_galleries = [
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

    public function event()
    {
        return $this->belongsTo(Event::class);
    }

    public function eventTemplateSections()
    {
        return $this->hasMany(EventTemplateSection::class);
    }

    /**
     * trae las traducciones de esta talla
     */
    public function photos()
    {
        return $this->belongsToMany(Photo::class,$this->photo_table,"event_template_id","photo_id")->withPivot($this->photoable)->withTimestamps();
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getIdAttribute()
    {
        return $this->attributes['event_id'];
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getTemplateViewAttribute()
    {
        $header = $this->eventTemplateHeader;

        if (!$header) {
            return null;
        }
        return $header->view;
    }

    public function eventTemplateHeader()
    {
        return $this->belongsTo(EventTemplateHeader::class);
    }

    /**
     * Get the template id
     *
     * @return integer
     */
    public function getEventTemplateHeaderIdAttribute()
    {
        return $this->attributes['event_template_header_id'];
    }

    public function colorPalette()
    {
        return $this->belongsTo(ColorPalette::class);
    }

}
