<?php

namespace App\Models\Products;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Traits\SkuSuffixTrait;
use App\Models\Shop\Bag;
use App\User;

class Provider extends Model
{
    use SoftDeletes;
    use SkuSuffixTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'providers';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at"
    ];

    /**
    * The attributes that are mass assignable.
    *
    * @var array
    */
    protected $fillable = [
        'sku_suffix',
        'slug',
        'label'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'admin_url'
    ];

    public function isDeletable()
    {
        $total = 0;
        $total += $this->products->count();
        return $total == 0;
    }

    public static function generateUniqueSlug($name)
    {
        $slug = str_slug($name);

        $not_unique_slug = true;
        $gluter = "-";
        while ($not_unique_slug) {
            $providers = static::withTrashed()->where(["slug" => $slug])->get();
            if ($providers->count() == 0) {
                $not_unique_slug = false;
            }else {
                $slug.= $gluter.rand(0,9);
            }
            $gluter = "";
        }

        return $slug;
    }

    public function updateUniqueSlug( $new_name )
    {
        if (trim(strtolower($new_name))  == trim(strtolower($this->label)) ) {
            return $this->slug;
        }

        return static::generateUniqueSlug($new_name);
    }

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function getAdminUrlAttribute()
    {
        return route('admin::providers.show', $this->id);
    }

    public function products_skus_bags()
    {
        // SQL Query
        // select * from bags join bag_sku on bags.id = bag_sku.bag_id join skus on skus.sku = bag_sku.sku_sku join products on skus.product_id = products.id where bags.bag_status_id > 1 and bags.bag_status_id < 6 and (bags.bag_type_id = 2 or bags.bag_type_id = 4)

        return $this
        ->products()
        ->with(['skus' => function($query){
            $query->with(['bags' => function($query_bag) {
                return $query_bag
                ->whereHas('bagStatus', function($query_bag_status){
                    return $query_bag_status
                    ->where([
                        ['paid', '=', '1'],
                        ['cancel', '=', '0'],
                        ['active', '=', '0'],
                    ]);
                })
                ->whereHas('bagType', function($query_bag_type){
                    return $query_bag_type
                    ->where('slug', 'personal')
                    ->orWhere('slug', 'retirar-mesa-de-regalos');
                })
                ->orderBy('purshased_at', 'desc');
            }])
            ->whereHas('bags', function($query_bag) {
                return $query_bag
                ->whereHas('bagStatus', function($query_bag_status){
                    return $query_bag_status
                    ->where([
                        ['paid', '=', '1'],
                        ['cancel', '=', '0'],
                        ['active', '=', '0'],
                    ]);
                })
                ->whereHas('bagType', function($query_bag_type){
                    return $query_bag_type
                    ->where('slug', 'personal')
                    ->orWhere('slug', 'retirar-mesa-de-regalos');
                })
                ->orderBy('purshased_at', 'desc');
            });
        }])
        ->whereHas('skus', function($query){
            $query->with(['bags' => function($query_bag) {
                return $query_bag
                ->whereHas('bagStatus', function($query_bag_status){
                    return $query_bag_status
                    ->where([
                        ['paid', '=', '1'],
                        ['cancel', '=', '0'],
                        ['active', '=', '0'],
                    ]);
                })
                ->whereHas('bagType', function($query_bag_type){
                    return $query_bag_type
                    ->where('slug', 'personal')
                    ->orWhere('slug', 'retirar-mesa-de-regalos');
                })
                ->orderBy('purshased_at', 'desc');
            }])
            ->whereHas('bags', function($query_bag) {
                return $query_bag
                ->whereHas('bagStatus', function($query_bag_status){
                    return $query_bag_status
                    ->where([
                        ['paid', '=', '1'],
                        ['cancel', '=', '0'],
                        ['active', '=', '0'],
                    ]);
                })
                ->whereHas('bagType', function($query_bag_type){
                    return $query_bag_type
                    ->where('slug', 'personal')
                    ->orWhere('slug', 'retirar-mesa-de-regalos');
                })
                ->orderBy('purshased_at', 'desc');
            });
        })
        ->get();
    }

}
