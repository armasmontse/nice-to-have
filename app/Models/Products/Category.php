<?php

namespace App\Models\Products;

use App\Models\Traits\TranslationTrait;
use App\Models\Traits\UniqueSlugTrait;
use App\Models\Abstracts\ShopFilterAbstract;

class Category extends ShopFilterAbstract
{
    use UniqueSlugTrait;
    use TranslationTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'categories';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'category_language';

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
        'client_url',
        'object_type',
        // 'es'
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

    public function getClientUrlAttribute()
    {
        return route( 'client::shop.filters.category', [$this->translation()->slug] );
    }

    /**
     * Trae los paises  del grupo
     */
    public function subcategories()
    {
        return $this->hasMany(Subcategory::class);
    }


    /**
     * agrega un pais paises al grupo
     */
    public function addSubcategory(Subcategory $subcategory)
    {
        return $this->subcategories()->save($subcategory);
    }


    public function isDeletable()
    {
        $total = 0;
        $total += $this->subcategories->count();
        return $total == 0;
    }

}
