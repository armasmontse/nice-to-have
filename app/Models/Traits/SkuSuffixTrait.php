<?php namespace App\Models\Traits;

trait SkuSuffixTrait {
    
    public static function GetBySkuSuffix($sku_suffix)
    {
        if (in_array("Illuminate\Database\Eloquent\SoftDeletes",  class_uses(static::class))) {
            return static::withTrashed()->where(["sku_suffix" => $sku_suffix])->get();
        }
        return static::where(["sku_suffix" => $sku_suffix])->get();
    }

    public static function generateUniqueSkuSuffixBySlug($slug)
    {
        $not_unique = true;
        $numberOfLettersOfSlug = 3;
        $iteration_counter = 0;
        $first_letter = static::getFirstLetterOfCurrentClass();

        while ($not_unique) {
            $sku_suffix = $first_letter.static::getLettersForSku( $slug , $numberOfLettersOfSlug);

            if ( static::GetBySkuSuffix($sku_suffix)->count() == 0 ) {
                $not_unique = false;
            }

            $iteration_counter++;

            if ($iteration_counter > 1 ) {
                $numberOfLettersOfSlug = 2;
            }

            if ($iteration_counter > 20 ) {
                $numberOfLettersOfSlug = 1;
            }

            if ($iteration_counter > 500 ) {
                $numberOfLettersOfSlug = 0;
            }
        }
        // dd($iteration_counter);
        return $sku_suffix;
    }

    public static function generateUniqueSkuSuffixByName($name)
    {
        return static::generateUniqueSkuSuffixBySlug(str_slug($name));
    }

    public static function getLettersForSku($slug, $numberOfLettersOfSlug = 2 ) {
    	$trozos = explode('-',trim($slug));
    	$letters = '';
        foreach ($trozos as $key => $trozo) {
            $letters .= substr($trozo,0,1);
        }
        $letters= str_pad($letters,$numberOfLettersOfSlug, chr(rand(ord('a'), ord('z'))) );

        $letters =  substr($letters,0,$numberOfLettersOfSlug);

        for ($i=1; $i <= (3-$numberOfLettersOfSlug ); $i++) {
            $letters .= chr(rand(ord('a'), ord('z')));
        }

    	return strtolower($letters);
    }


    public static function getFirstLetterOfCurrentClass(){
        $class_name = get_class(new static);
        $class_name_without_namespace = substr(strrchr($class_name, "\\"), 1) ;
        $class_name_without_namespace = $class_name_without_namespace ? $class_name_without_namespace :  $class_name;
        return strtoupper(substr(trim($class_name_without_namespace),0,1));
    }

    public static function generateSkuSuffix($slug, $numberOfLettersOfSlug = 2 ){

        $sku_suffix = static::getFirstLetterOfCurrentClass().static::getLettersForSku($slug, $numberOfLettersOfSlug );

        return $sku_suffix;
    }

    public static function getSuffixFor($object_id)
    {
        $object = static::find($object_id);
        if ($object) {
            return $object->sku_suffix;
        }
        return static::getFirstLetterOfCurrentClass()."000";
    }

}
