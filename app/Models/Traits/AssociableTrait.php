<?php namespace App\Models\Traits;

trait AssociableTrait {

    public static function getTableOfAssociateModelForCode($code)
    {

        if ( isset(static::$associable_models[$code] ) ) {
            $class_name = static::$associable_models[$code] ;
            return (new $class_name)->getTable();
        }

        return false;
    }

    public static function getImpodeCodesToAssociateModels()
    {
        return implode(",",array_keys(static::$associable_models));
    }

}
