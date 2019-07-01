<?php

namespace App\Models\Address;

use Illuminate\Database\Eloquent\Model;
use App\Models\Traits\TranslationTrait;
use App\Language;

class Country extends Model
{
    use TranslationTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'countries';

    protected $translation_table = 'country_language';

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'iso3166'
    ];

    protected $translatable = [
        'official_name'
    ];

    public function addresses()
    {
        return $this->hasMany(Address::class);
    }

    public function getOfficialNameAttribute()
    {
        return $this->translation()->official_name;
    }

    public function scopeGetModelByName($query, $official_name)
    {
        return $query->whereHas('languages', function ($pivot_query) use ($official_name) {
            $pivot_query->where('official_name', $official_name);
        })->with('languages')->get();
    }

    public function scopeByIso($query, $iso)
    {
        return $query->where(['iso3166' => $iso]);
    }

    public static function getCountryByName($country_name)
    {
        $countries = static::GetModelByName($country_name);
        return $countries->count() > 0 ? $countries->first() : null;
    }

    public static function getMexico()
    {
        return static::getCountryByName("México");
    }

    public static function getMexicoStates()
    {
        return static::getMexicoStatesiWithMunicipies()->keys();
    }

    public static function getMexicoStatesiWithMunicipies()
    {
        return static::getMexicoStatesiAndMunicipiesFromCSV()->sort(function ($a, $b) {
            if ($a['state_slug'] === $b['state_slug']) {
                if ($a['mun_slug'] === $b['mun_slug']) {
                    return 0;
                }
                return $a['mun_slug'] < $b['mun_slug'] ? -1 : 1;
            }
            return $a['state_slug'] < $b['state_slug'] ? -1 : 1;
        })->groupBy('NOM_ENT,C,110');
    }

    public static function getMexicoStatesiAndMunicipiesFromCSV()
    {
        $csvFile = storage_path('app/cltvo/states/cat_municipio_ABR2016.csv');
        return collect(csv_to_array($csvFile));
    }

    public static function inZMVM($state, $municipie)
    {
        $miunicipie = static::getMexicoStatesiAndMunicipiesFromCSV()->where("NOM_ENT,C,110", $state)->where("NOM_MUN,C,110", $municipie) ->first();
        return boolval($miunicipie ? $miunicipie["IS_IN_ZMVM"] : false);
    }
}
