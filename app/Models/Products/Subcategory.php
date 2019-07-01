<?php

namespace App\Models\Products;

use App\Models\Traits\TranslationTrait;
use App\Models\Traits\UniqueSlugTrait;
use App\Models\Abstracts\ShopFilterAbstract;

class Subcategory extends ShopFilterAbstract
{
    use UniqueSlugTrait;
    use TranslationTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'subcategories';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'language_subcategory';

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
        'category_id',
        'order'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order' => 'integer',
        'category_id' => 'integer',
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
        'client_url',
        'category_label',
        'object_type',
        // 'parent_label',
        // 'parent_client_url'
    ];


    public function getClientUrlAttribute()
    {
        return route( 'client::shop.filters.subcategory', [$this->category->slug, $this->slug] );
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
    public function getCategoryLabelAttribute()
    {
        return $this->category->label;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getParentLabelAttribute()
    {
        return $this->category->label;
    }


    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getParentClientUrlAttribute()
    {
        return $this->category->client_url;
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
     * trae la categoria
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * agrega una categoria
     */
    public function assignCategory(Category $category )
    {
        return $this->category()->associate($category);
    }

    public function products()
    {
        return $this->belongsToMany(Product::class)->withTrashed();
    }

    public function isDeletable()
    {
        $total = 0;
        $total += $this->products->count();
        return $total == 0;
    }
}
