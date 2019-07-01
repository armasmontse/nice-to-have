<?php

namespace App\Models\Events;

use App\Models\Traits\TranslationTrait;
use App\Models\Traits\UniqueSlugTrait;
use App\Models\Abstracts\ShopFilterAbstract;

use App\Models\Products\Product;

class Subtype extends ShopFilterAbstract
{
    use UniqueSlugTrait;
    use TranslationTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subtypes';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'language_subtype';

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
        'type_id',
        'order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'integer',
        'type_id' => 'integer',
    ];

    protected  $translatable = [
        'slug',
        'label'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'slug',
        'label',
        // 'es'
        'type_label',
        'object_type',
        // 'client_url',

        // 'parent_label',
        // 'parent_client_url'
    ];

    public function getClientUrlAttribute()
    {
        return route( 'client::shop.filters.subtype', [$this->type->slug, $this->slug] );
    }

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
    public function getTypeLabelAttribute()
    {
        return $this->type->label;
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
    public function getParentLabelAttribute()
    {
        return $this->type->label;
    }


    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getParentClientUrlAttribute()
    {
        return $this->type->client_url;
    }

    /**
     * trae la categoria
     */
    public function type()
    {
        return $this->belongsTo(Type::class);
    }

    /**
     * agrega una categoria
     */
    public function assignType(Type $type )
    {
        return $this->type()->associate($type);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTrashed();
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
        $total += $this->products->count();
        $total += $this->events->count();
        return $total == 0;
    }

}
