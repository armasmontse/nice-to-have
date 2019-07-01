<?php
namespace App\Models\Products;

use App\Models\Traits\TranslationTrait;
use App\Models\Traits\UniqueSlugTrait;
use App\Models\Traits\Products\UniqueCodeTrait;
use App\Models\Traits\PhotoableTrait;
use App\Models\Traits\PublishableTrait;
use App\Models\Traits\Seo\SeoableTrait;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

use App\Models\Events\Subtype;
use App\Models\Skus\Sku;

use Auth;

use App\Models\Shop\Bag;

use stdClass;

class Product extends Model
{
    use SoftDeletes;

    use TranslationTrait;
    use UniqueSlugTrait;
    use UniqueCodeTrait;

    use PhotoableTrait;
    use PublishableTrait;
    use SeoableTrait;

    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'products';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'language_product';

    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
    protected $hidden = [
        "created_at",
        "updated_at",
        "deleted_at",
        "publish",
        "languages",
		'publish_id',
		'publish_at',
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'provider_id',
        'code',
		'publish_id',
		'publish_at',
    ];

    /**
     * The attributes that should be casted to native types.
     *
     * @var array
     */
    protected $casts = [
        'provider_id' => 'integer',
		'publish_at'	=> 'date'
    ];

    protected  $translatable = [
        'slug',
        'title',
        'description'
    ];

    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'slug',
        'title',
        'description',
        "is_publish",
        "default_sku",
        // "edit_url",
        "client_url",
        "event_shop_url",
        // 'es',
        "subtypes_ids",
        "subcategories_ids",
        'publish_properties',
    ];

	public static $image_uses = [
        'details',
    ];

    public static $image_galleries = [
    ];

    public function getSlugAttribute()
    {
        return $this->translation()->slug;
    }

    public function getTitleAttribute()
    {
        return $this->translation()->title;
    }

    public function getDescriptionAttribute()
    {
        return nl2br($this->translation()->description);
    }

    public function getProductsAttribute()
    {
        return $this->productsRelatedTo()->merge($this->productsRelatedIn());
    }

    public function getDefaultSkuAttribute()
    {
        $sku = $this->skus()->where("default", true)->first();

        if (!$sku) {
            $sku = new stdClass;
            $sku->thumbnail_image = new stdClass;
        }

        return $sku ? $sku : new stdClass;
    }

    public function getEditUrlAttribute()
    {
        return  route( 'admin::products.edit', [$this->id] );
    }

    public function getClientUrlAttribute()
    {
        return route( 'client::single.show', [$this->translation()->slug] );
    }

    public function getEventShopUrlAttribute()
    {
        if (session("cookie_event")) {
            return route( 'client::events.shop.single', [session("cookie_event")->slug,$this->translation()->slug] );
        }
        return null;
    }

    public function getSubtypesIdsAttribute()
    {
        return $this->subtypes()->select(["id"])->get()->map(function($subtype){
            return $subtype->id;
        });
    }

    public function getSubcategoriesIdsAttribute()
    {
        return $this->subcategories()->select(["id"])->get()->map(function($subcategory){
            return $subcategory->id;
        });
    }

    public function productSections()
    {
        return $this->hasMany(ProductSection::class)->with("languages")->orderBy("order");
    }

    /**
     * productos relacionados
     */
    public function productsRelated()
    {
        return $this->belongsToMany(Product::class, "product_product", "product_id", "product_id_related");
    }

    /**
     * relacionado con los productos
     */
    public function relatedInProducts()
    {
        return $this->belongsToMany(Product::class, "product_product", "product_id_related", "product_id");
    }

    public function productsRelatedTo()
    {
        $user = Auth::user();

        $products = $this->productsRelated();

        if (!$user || !$user->hasPermission("manage_products") ) {
            $products = $products->public();
        }

        return $products->get();
    }

    public function productsRelatedIn()
    {
        $user = Auth::user();

        $products = $this->relatedInProducts();

        if (!$user || !$user->hasPermission("manage_products") ) {
            $products = $products->public();
        }

        return $products->get();
    }

    public function scopePublic($query)
    {
        return $query->default()->published();
    }

    public function scopeDefault($query)
    {
        return $query->whereHas('skus', function($q) { $q->where(["default" => true ]); });
    }

    public function subcategories()
    {
        return $this->belongsToMany(Subcategory::class);
    }

    public function subtypes()
    {
        return $this->belongsToMany(Subtype::class);
    }

    public function skus()
    {
        return $this->hasMany(sku::class)->with("languages")->orderBy("updated_at","desc");
    }

    public function provider()
    {
        return $this->belongsTo(Provider::class)->withTrashed();
    }

    public function scopeFromBag($query, Bag $bag)
    {
        return $query->whereHas("skus",function($q) use ($bag){
            return $q->whereHas("bags", function($queried) use ($bag){
                return $queried->where(["id" => $bag->id]);
            });
        });
    }

    public function getPublishPropertiesAttribute()
    {
        return (object) [
            "is_publish" => $this->publish ? $this->publish->is_publish : false,
            "publish_at"         => $this->publish_at ? $this->publish_at->format("Y-m-d") : date("Y-m-d")
        ];
    }

    public function updateUniqueSlug($new_name, $language_iso)
    {
        if (trim(strtolower($new_name)) == trim(strtolower($this->translation($language_iso)->title)))
        {
            return $this->translation($language_iso)->slug;
        }

        return static::generateUniqueSlug($new_name);
    }

}
