<?php

namespace App\Models\Seo;

use App\Models\Traits\TranslationTrait;
use App\Models\Traits\PhotoableTrait;

use App\Setting;

use Illuminate\Database\Eloquent\Model;

use stdClass;

class Seo extends Model
{
    use TranslationTrait;
    use PhotoableTrait;

    protected $table = 'seo';

    protected $translation_table = 'language_seo';

    protected $hidden = [
        "created_at",
        "updated_at",
        "route_name"
    ];

    protected $fillable = [
        'route_name',
		'seoable_id',
		'seoable_type',
    ];

    protected $casts = [
        'route_name'    => 'string',
        'seoable_id'    => 'integer',
		'seoable_type'  => 'string'
    ];

    protected $translatable = [
        'title',
        'description'
    ];

    protected $appends = [
        'title',
        'description',
        'thumbnail_image',
    ];

    public function getTitleAttribute()
    {
        return $this->translation()->title;
    }

    public function getDescriptionAttribute()
    {
        return $this->translation()->description;
    }

    public function getThumbnailImageAttribute()
    {
        $photo = $this->getFirstPhotoTo(["use"=>"thumbnail"]);
        return $photo ? $photo : new stdClass;
    }

    public function seoable()
    {
        return $this->morphTo();
    }

    public function scopeRoute($query, $route)
    {
        return $query->where('route_name', $route);
    }

    public static function getSEO($route)
    {
        $seo = static::route($route)->first();

        if (!$seo) {

            $seo = static::createSeo();
        }

        return $seo;
    }

    public static function createSeo($title = null, $description = null, $thumbnail = null)
    {
        $iso = session('lang') ? session('lang') : \App::getLocale();
        $setting = Setting::getDescription();

        $title = !is_null($title) ? $title : env('APPNOMBRE');
        $description = !is_null($description) ? $description : (isset($setting['description'][$iso]) ? $setting['description'][$iso] : "");
        $thumbnail = !is_null($thumbnail) ? $thumbnail : (isset($setting->thumbnail_image->url) ? $setting->thumbnail_image->url : "");

        $seo = new stdClass;
        $seo->thumbnail_image = new stdClass;

        $seo->title = $title;
        $seo->description = $description;
        $seo->thumbnail_image->url = $thumbnail;

        return $seo;
    }

}
