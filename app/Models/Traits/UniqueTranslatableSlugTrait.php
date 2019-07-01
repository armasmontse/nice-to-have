<?php

namespace App\Models\Traits;

use DB;

trait UniqueTranslatableSlugTrait
{
    /**
     * genera un nombre de usuario unico a partir del nombre y apellido
     * @param  string $name     nombre
     * @return string           slug
     */
    public static function generateUniqueSlug($name)
    {
        $slug = str_slug(trim($name));
        $slug_is_not_unique = true;
        $gluter = "-";

        while ($slug_is_not_unique) {
            if (!static::slugExist($slug)) {
                $slug_is_not_unique = false;
            }else {
                $slug.= $gluter.rand(0,9);
            }
            $gluter = "";
        }

        return $slug;
    }

    public static function slugExist($slug)
    {
        $table = with(new static)->getTranslationTable();
        return DB::table($table)->where('slug', $slug)->count() > 0;
    }

    public function scopeGetModelBySlug($query, $slug)
    {
        return $query->whereHas('languages', function($pivot_query) use($slug) {
            $pivot_query->where('slug', $slug);
        })->with('languages');
    }

    public static function getObjectBySlug($slug)
    {
        $models = static::getModelBySlug($slug)->get();
        return $models->count() > 0 ? $models->first() : null;
    }

    public function updateUniqueSlug( $new_name, $language_iso )
    {
        if (trim(strtolower($new_name))  == trim(strtolower($this->translation($language_iso)->label)) ) {
            return $this->translation($language_iso)->slug;
        }

        return static::generateUniqueSlug($new_name);
    }

    public function getSlugAttribute()
    {
        return $this->translation()->slug;
    }
}
