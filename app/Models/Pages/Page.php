<?php

namespace App\Models\Pages;

use Illuminate\Database\Eloquent\Model;

use App\Models\Traits\TranslationTrait;
use App\Models\Traits\UniqueTranslatableSlugTrait;
use App\Models\Traits\PublishableTrait;
use App\Models\Traits\UpdatedAtTrait;
use App\Models\Traits\Seo\SeoableTrait;

use App\Models\Pages\Sections\Section;

class Page extends Model
{

    use TranslationTrait;
    use UniqueTranslatableSlugTrait;
    use PublishableTrait;
    use UpdatedAtTrait;
    use SeoableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'pages';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'language_page';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'index',
        'order',
        'parent_id',

        'publish_id',
        'publish_at',

        'tblank',
    ];

    protected $translatable = [
        'label',
        'slug',
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'complete_label',
        'public_url',
        'edit_content_url',
        'sections_ids',
        'sections_minified',
        'sections_maped'
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'order'    => 'integer',

        'parent_id'    => 'integer',
        'publish_id'    => 'integer',

        'main'      => 'boolean',
        'tblank'    => 'boolean',
    ];

    protected $dates = [
        'created_at',
        'updated_at',
        'publish_at'
    ];

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "sections",
        "created_at",
        "updated_at",
    ];

    /**
     * Get the current language label.
     *
     * @return bool
     */
    public function getLabelAttribute()
    {
        return $this->translation()->label;
    }

    /**
     * Get the current language slug.
     *
     * @return bool
     */
    public function getSlugAttribute()
    {
        return $this->translation()->slug;
    }

    /**
     * Get public url
     *
     * @return bool
     */
    public function getPublicUrlAttribute()
    {
        if ($this->main) {
            return route("client::pages.index");
        }

        if ($this->parent_id) {
            return route("client::pages.showChild",[$this->parent->slug,$this->slug]);
        }
        return route("client::pages.show",$this->slug);
    }

    /**
     * Get related sections ids
     *
     * @return bool
     */
    public function getSectionsIdsAttribute()
    {
        return $this->sections->pluck("id");
    }

    /**
     * Get related sections id and index
     *
     * @return bool
     */
    public function getSectionsMapedAttribute()
    {
        return $this->sections->map(function($section){
            return $section->maped;
        });
    }

    /**
     * Get related sections id and index
     *
     * @return bool
     */
    public function getSectionsMinifiedAttribute()
    {
        return $this->sections->map(function($section){
            return $section->minified;
        });
    }

    /**
     * Get edit content url
     *
     * @return bool
     */
    public function getEditContentUrlAttribute()
    {
        return route("admin::pages.contents.edit",$this->id);
    }

    /**
     * Get edit structure url
     *
     * @return bool
     */
    public function getEditUrlAttribute()
    {
        return route("admin::pages.edit",$this->id);
    }

    /**
     * Get name with index
     *
     * @return bool
     */
    public function getCompleteLabelAttribute()
    {
        return $this->label."<br><small>(".$this->index.")</small>";
    }

    /**
     * Get parent name with index
     *
     * @return bool
     */
    public function getParentLabelAttribute()
    {
        return $this->main ? "Principal" : ($this->parent ? $this->parent->complete_label :"Sin padre");
    }

    /**
     * Get parent index
     *
     * @return bool
     */
    public function getParentIndexAttribute()
    {
        return $this->parent ? $this->parent->index :"cltvo-n-a";
    }


    public function childs()
    {
        return $this->hasMany(static::class, 'parent_id')->orderBy('order', 'ASC');
    }

    public function parent()
    {
        return $this->belongsTo(static::class, 'parent_id');
    }


    public static function getMainPage()
    {
        return static::where(["main" => true])->first();
    }

    // start; Función para saber si una página es padre.

    public function isParent()
    {
        return is_null($this->parent);
    }

    // start; Función scope para obtener las páginas que no tienen padres.

    public function scopeParents($query)
    {
        return $query->doesntHave('parent');
    }

    /**
     * The sections that belong to the page.
     */
    public function sections()
    {
        return $this->belongsToMany(Section::class)
            ->withPivot(["order"])
            ->orderBy('pivot_order',"ASC")
            ->withTimestamps();
    }

    // Get only not main pages

    public function scopeNotMain($query)
    {
        return $query->where([ 'main' => false ]);
    }

    public function isDeletable()
    {
        $total = 0;
        $total += $this->childs->count();
        return $total == 0;
    }

}
