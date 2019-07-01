<?php

namespace App\Models\Products;

use App\Models\Traits\TranslationTrait;

use Illuminate\Database\Eloquent\Model;

class ProductSection extends Model
{

    use TranslationTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'product_sections';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'language_product_section';

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
        'order',
        'product_id',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order'         => 'integer',
        'product_id'    => 'integer'
    ];

    protected  $translatable = [
        'title',
        'content'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'title',
        'content',
        'br_content',
        // 'es',
    ];

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
    public function getContentAttribute()
    {
        return $this->translation()->content;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getBrContentAttribute()
    {
        return nl2br($this->content);
    }

    /**
     * trae la categoria
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
