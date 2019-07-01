<?php namespace App\Http\Helpers;

use Illuminate\Support\Facades\Redis;

use App\Models\Events\Type;
use App\Models\Events\Subtype;
use App\Models\Products\Category;
use App\Models\Products\Subcategory;

use App\Models\Products\Product;
use Carbon\Carbon;

/**
 *
 */
class CacheHelper
{

    const GENERATE_BASE = "generateCache";

    const CACHE_DATE    = "last_cache_update";
    const MYSQL_DATE    = "last_mysql_update";
    const REDIS_PREFIX    = "nth:";

    protected static $cache_available = [
        'MSCategories',
        'MSSubcategories',

        'MSTypes',
        'MSSubtypes',

        'MSProducts',
    ];

    public static function getCacheByKey($key)
    {
        $output = Redis::get(static::REDIS_PREFIX.$key);

        if (!$output && in_array($key, static::$cache_available)) {
            $output = static::generateCacheByKey($key);
        }
        return $output;

    }


    public static function generateCacheByKey($key)
    {
        Redis::set(static::REDIS_PREFIX.$key, static::{static::GENERATE_BASE.$key}());
        return Redis::get(static::REDIS_PREFIX.$key);
    }


    public static function updateAllAvailableCaches()
    {
        foreach (static::$cache_available as $key) {
            static::generateCacheByKey($key);
        }
        static::updateCacheTimestamp();
    }

    public static function updateCacheTimestamp()
    {
        Redis::set(static::REDIS_PREFIX.static::CACHE_DATE, Carbon::now());
    }

    public static function updateMYSQLTimestamp()
    {
        Redis::set(static::REDIS_PREFIX.static::MYSQL_DATE, Carbon::now());
    }

    public static function isCacheUpdated()
    {
        $mysql_date = Redis::get(static::REDIS_PREFIX.static::MYSQL_DATE);
        $cache_date = Redis::get(static::REDIS_PREFIX.static::CACHE_DATE);


        if (!$mysql_date && !$cache_date) {
            return false;
        }
        try {
            $cache_date = Carbon::parse($cache_date);
            $mysql_date = Carbon::parse($mysql_date);
        } catch (Exception $e) {
            return false;
        }

        return $cache_date->gte($mysql_date);
    }



    public static function generateCacheMSTypes()
    {
        return Type::with(["languages","subtypes" => function($q){
            return $q->orderBy("order");
        },"subtypes.languages"])->has("subtypes")->orderBy("order")->GetWithTranslations()->get();
    }


    public static function generateCacheMSCategories()
    {
        return Category::orderBy("order","asc")->has("subcategories")->with(["languages","subcategories" => function($q){
            return $q->orderBy("order");
        },"subcategories.languages"])->GetWithTranslations()->get();
    }


    public static function generateCacheMSSubtypes()
    {
        return Subtype::with("languages", "type", "type.languages")
                ->join('types', 'types.id', '=', 'subtypes.type_id')
                ->orderBy("type_order")
                ->orderBy("order")
                ->GetWithTranslations([
                    'types.order as type_order'
                ])
                ->get();
    }


    public static function generateCacheMSSubcategories()
    {
        return  Subcategory::with("languages", "category", "category.languages")
                ->orderBy("category_order")
                ->orderBy("order")
                ->join('categories', 'categories.id', '=', 'subcategories.category_id')
                ->GetWithTranslations([
                    'categories.order as category_order'
                ])
                ->get();
    }

    public static function generateCacheMSPublicProducts()
    {
        return Product::with([])
            ->public()
            ->orderBy('provider_id', 'desc')
            ->orderedBy('title')
            ->get();
    }

    public static function generateCacheMSProducts()
    {
        return Product::with([])
            ->orderBy('provider_id', 'desc')
            ->orderedBy('title')
            ->get();
    }



}
