<?php

namespace App\Models\Events;

use App\Models\Traits\TranslationTrait;
use App\Models\Traits\UniqueSlugTrait;
use App\Models\Abstracts\ShopFilterAbstract;
use App\Models\Traits\PhotoableTrait;

use stdClass;

class Type extends ShopFilterAbstract
{
    use UniqueSlugTrait;
    use TranslationTrait;
    use PhotoableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'types';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'language_type';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
        "languages",
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'integer',
    ];

    protected  $translatable = [
        'slug',
        'label',
        'title',
        'description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'slug',
        'label',
        'title',
        'description',
        // 'client_url',
        'thumbnail_image',
        'object_type',
        // 'es',
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
    public function getSlugAttribute()
    {
        return $this->translation()->slug;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getLabelAttribute()
    {
        return $this->translation()->label;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getTitleAttribute()
    {
        return $this->translation()->title;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getDescriptionAttribute()
    {
        return $this->translation()->description;
    }


    public function getClientUrlAttribute()
    {
        return route( 'client::shop.filters.type', [$this->translation()->slug] );
    }

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


    /**
     * Trae los paises  del grupo
     */
    public function subtypes()
    {
        return $this->hasMany(Subtype::class);
    }


    /**
     * agrega un pais paises al grupo
     */
    public function addSubtype(Subtype $subtype)
    {
        return $this->subtypes()->save($subtype);
    }

    /**
     * Get all of the post's comments.
     */
    public function events()
    {
        return $this->morphMany(Event::class, 'typeable');
    }

    public function isDeletable()
    {
        $total = 0;
        $total += $this->subtypes->count();
        $total += $this->events->count();
        return $total == 0;
    }

}
