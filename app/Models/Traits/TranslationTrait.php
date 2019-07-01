<?php namespace App\Models\Traits;

use Illuminate\Database\Eloquent\Collection;
use App\User;
use App\Language;

use App;
use Image;
use Response;

use DB;

trait TranslationTrait {

    /**
     * trae las traducciones de esta talla
     */
    public function languages()
    {
        // $select = "";
        // foreach (Language::get()  as  $language) {
        //     foreach ($this->translatable as $translatable) {
        //         $select .= " max(if(".$this->translation_table.".language_id = ".$language->id.",".$this->translation_table.".".$translatable.",null))"." as $language->iso6391"."_".$translatable."," ;
        //     }
        // }
        // dd($select,"muere");
        return $this->belongsToMany(Language::class)
            ->select('languages.id','languages.iso6391','languages.label as language_label',$this->translation_table.".*")
            // ->groupBy("languages.id")
            ->withPivot($this->translatable)
            ->withTimestamps( )
            ;
    }


    // /**
    //  * Get the administrator flag for the user.
    //  *
    //  * @return bool
    //  */
    // public function getEsAttribute()
    // {
    //     return $this->translation("es");
    // }


    /**
     * Asigna leguage a ser asignado
     * @param  Languge $language traduccion a ser asignado
     */
    public function assignTranslation(Language $language,array $translation)
    {
        return $this->languages()->save($language, $translation);
    }

    /**
     * Asigna leguage a ser asignado
     * @param  string $languageIso iso de la traduccion a ser asignado
     */
    public function assignTranslationByIso($languageIso,array $translation)
    {
        $language = Language::getLanguageByIso($languageIso);
        return $this->languages()->save($language, $translation);
    }

    /**
     * actualiza la traduccion de un modelo
     * @param  language $language          idioma a cambiar
     * @param  array    $translationUpdate traducciones
     */
    public function updateTranslation(Language $language,array $translationUpdate)
    {
        $translation = $this->languages->find($language->id);

        if (!$translation) {
            return $this->assignTranslation( $language,$translationUpdate);
        }
        return $this->languages()->updateExistingPivot($language->id, $translationUpdate);
    }

    /**
     * actualiza la traduccion de un modelo por medio del iso6391
     * @param  string   $languageIso       iso6391 sel idioma a cambiar
     * @param  array    $translationUpdate traducciones
     */
    public function updateTranslationByIso($languageIso,array $translationUpdate)
    {
        $language = Language::getLanguageByIso($languageIso);
        return $this->updateTranslation($language, $translationUpdate);
    }

    /**
     * regresa la traduccion de un objeto
     * @param  string $languageIso iso6391 sel idioma
     */
    public function translation($languageIso = null)
    {
        if (!Language::languageExist($languageIso)) { // si no existe tomamos el del sistema
            $languageIso = App::getLocale();
        }

        $translation = $this->languages()->where(["iso6391"=>$languageIso])->get()->first();

        if (!$translation) {
            $this->assignTranslationByIso($languageIso, []);
            $translation = $this->languages()->where(["iso6391"=>$languageIso])->get()->first();
        }
        return $translation->pivot;
    }


    public function getImpldeValue($key, $glue_open = " (",$glue_clouse= ") ")
    {
        $nombre_compuesto = "";

        foreach ($this->languages as $language) {
            if (!$language->isCurrentLanguage()) {
                $nombre_compuesto .= $glue_open;
            }
            $nombre_compuesto .= $language->pivot->$key;
            if (!$language->isCurrentLanguage()) {
                $nombre_compuesto .= $glue_clouse;
            }
        }

        return $nombre_compuesto ;
    }

    public function getTranslationTable()
    {
        return $this->translation_table;
    }

    public function scopeGetAllWithTranslations($query)
    {
        return $query->with("languages")->orderBy('id', 'DESC');
    }

    public function scopeGetWithTranslations($query, array $selects = [])
    {
        $class = snake_case(array_last(explode('\\', get_called_class())));
        return $query
            ->with("languages")
            ->select(
                array_merge(
                    [
                        $this->table.".*",
                        DB::raw( implode(",", $this->transformLanguageRowInColumn() ))
                    ],
                    $selects
                )
            )
            ->groupBy($this->table.".id")
            ->leftJoin($this->translation_table, $this->table.'.id', '=', $this->translation_table.'.'.$class.'_id')
            ->orderBy('id', 'DESC');
    }

    protected function transformLanguageRowInColumn()
    {
        $select = [];
        foreach (Language::get()  as  $language) {
            foreach ($this->translatable as $translatable) {
                $select[]= " max(if(".$this->translation_table.".language_id = ".$language->id.",if(".$this->translation_table.".".$translatable." is NULL, '', ".$this->translation_table.".".$translatable." ) ,''))"." as $language->iso6391"."_".$translatable;
            }
        }
        return $select;
    }

    public function scopeOrderedBy($query, $column)
    {
        $lang_iso = session("lang") ? session("lang") : "es";

        $same = new static;
        $table = with($same)->getTable();
        $translation_table = with($same)->getTranslationTable();

        $class = snake_case(array_last(explode('\\', get_called_class())));

        return  $query
                ->select($table.'.*')
                ->join($translation_table, $table.'.id', '=', $translation_table.'.'.$class.'_id')
                ->join('languages', 'languages.id', '=', $translation_table.'.language_id')
                ->where('languages.iso6391', $lang_iso)
                ->orderBy($translation_table.'.'.$column);
    }

}
