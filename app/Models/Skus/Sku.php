<?php

namespace App\Models\Skus;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Collection;

use App\Models\Products\Product;

use App\Language;
use App\Photo;

use App\Models\Traits\Skus\UniqueSkuTrait;
use App\Models\Traits\TranslationTrait;
use App\Models\Traits\PhotoableTrait;

use PayPal\Api\Item as PaypalItem;

use DB;

use App\Models\Shop\Bag;

use stdClass;

class Sku extends Model
{
    use TranslationTrait;
    use UniqueSkuTrait;
    use PhotoableTrait;
    /**
     * The database table used by the model.
     *
     * @var string
     */
    protected $table = 'skus';

    /**
     * [$primaryKey description]
     * @var string
     */
    protected $primaryKey = 'sku';

    /**
     * [$incrementing description]
     * @var boolean
     */
    public $incrementing = false;

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $translation_table = 'language_sku';

    /**
     * The database table used by language pivot.
     *
     * @var string
     */
    protected $photo_table = 'photo_sku';
    /**
     * The attributes that should be hidden for arrays.
     *
     * @var array
     */
     protected $hidden = [
         "created_at",
         "updated_at",
         "deleted_at",
         "languages",
     ];

    /**
     * [$translatable description]
     * @var [type]
     */
    protected  $translatable = [
        'description'
    ];

    /**
     * The attributes that are mass assignable.
     *
     * @var array
     */
    protected $fillable = [
        'sku',
        'price',
        'local_shipping_rate',
        'national_shipping_rate',
        'discount',
        'default',
        'product_id'
    ];


    protected $casts = [
        'sku'                       => 'string',
        'price'                     => 'double',
        'local_shipping_rate'       => 'double',
        'national_shipping_rate'    => 'double',
        'discount'                  => 'integer',
        'default'                   => 'boolean',
        'product_id'                => 'integer',
    ];


    /**
     * The accessors to append to the model's array form.
     *
     * @var array
     */
    protected $appends = [
        'description',
        'thumbnail_image',
        'price_with_discount'
        // 'es'
    ];

	public static $image_uses = [
        'thumbnail',
    ];

    public static $image_galleries = [
    ];


    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getPriceWithDiscountAttribute()
    {
        return round($this->price*(1-$this->discount/100),2);
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getPivotPriceWithDiscountAttribute()
    {
        return $this->pivot ? $this->pivot->price*(1-$this->pivot->discount/100) : $this->price_with_discount;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getDescriptionAttribute()
    {
        return $this->translation()->description;
    }

    /**
     * Get the administrator flag for the user.
     *
     * @return bool
     */
    public function getThumbnailImageAttribute()
    {
        $photo = $this->getFirstPhotoTo(["use"=>"thumbnail"]);
        return $photo ? $photo : new stdClass;
    }


    /**
     * trae la categoria
     */
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function isDeletable()
    {
        $total = 0;
        //gafdg
        return $total == 0;
    }

    // public function getPriceWithDiscount()
    // {
    //     return getPriceForSkuOrPivot($this) ;
    // }

    public function hasDiscount()
    {
        return $this->discount != 0;
    }

    // public function menuShoppingBagMap($quantity = null )
    // {
    //     $price = $this->pivot ? $this->pivot->price :  $this->price;
    //     $discount = $this->pivot ? $this->pivot->discount :  $this->discount;
    //     return[
    //         "sku"           => $this->sku,
    //         "quantity"      => $this->pivot ? $this->pivot->quantity : ( !is_null($quantity) ? $quantity : 1),
    //         "display_price" => $price*(1- $this->discount /100),
    //         "price"         => $price,
    //         "discount"      => $discount,
    //         "color_name"    => $this->skuable->color ? $this->skuable->color->translation()->name : trans("single.no_color"),
    //         'size_name'     => $this->skuable->size ?  $this->skuable->size->translation()->name : 'N/A',
    //         'garment_name'  => $this->skuable->garment->translation()->name,
    //     ];
    // }
    //
    // public function shoppingBagGarmentMap(User $user = null)
    // {
    //     return $this->skuable->garment->shopppingBagMap($user,$this);
    // }
    //
    // public function conektaMap($factor)
    // {
    //     return [
    //         "name"          => $this->skuable->garment->translation()->name,
    //         "unit_price"    => intval( $this->pivot->price*$factor ),
    //         "sku"           => $this->sku,
    //         "description"   => ( $this->skuable->size ?  $this->skuable->size->translation()->name : '' ).($this->skuable->color && $this->skuable->size  ? "-": "").( $this->skuable->color ?  $this->skuable->color->translation()->name : '' )  ,
    //         "quantity"      => $this->pivot->quantity
    //     ];
    // }
    //
    // public function getDisplayName()
    // {
    //     $shopping_map  = $this->conektaMap(1);
    //     return $shopping_map["name"].( empty($shopping_map["description"]) ? "" : "(".$shopping_map["description"].")"  ) ;
    // }

    public function changeYourPriceAfterOfAtach()
    {
        // dd(abs( $this->price - $this->pivot->price) > 0.01 ,
        //         abs( $this->discount - $this->pivot->discount ) > 0.01 ,
        //         abs( $this->cost - $this->pivot->cost ) > 0.01  );
        return  abs( $this->price - $this->pivot->price) >= 0.01 ||
                abs( $this->discount - $this->pivot->discount ) >= 0.01 ||
                abs( $this->cost - $this->pivot->cost ) >= 0.01 ;
    }

    /**
     * trae las traducciones de esta talla
     */
    public function languages()
    {
        return $this->belongsToMany(Language::class,$this->translation_table,"sku_sku","language_id")->withPivot($this->translatable)->withTimestamps();
    }

    /**
     * trae las traducciones de esta talla
     */
    public function photos()
    {
        return $this->belongsToMany(Photo::class,$this->photo_table,"sku_sku","photo_id")->withPivot($this->photoable)->withTimestamps();
    }

    public function scopeGetWithTranslations($query, array $selects = [])
    {
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
            ->groupBy($this->table.".sku")
            ->join($this->translation_table, $this->table.'.sku', '=', $this->translation_table.'.sku_sku')
            ->orderBy('sku', 'DESC');
    }

    public function bags()
    {
        return $this->belongsToMany(Bag::class, 'bag_sku', 'sku_sku', 'bag_id')->withPivot(['parent_bag_id', 'quantity', 'price', 'discount', 'shipping_rate'])->withTimestamps();
    }

    public function conektaMap()
    {
        return [
            "name"          => $this->product->title,
            "unit_price"    => round((double)$this->price_with_discount*100 , 2),
            "sku"           => $this->sku,
            "description"   => $this->description,
            "quantity"      => $this->pivot->quantity
        ];
    }

    public function paypalMap()
    {
        return (new PaypalItem)->setName($this->product->title)
            ->setCurrency('MXN')
            ->setQuantity($this->pivot->quantity)
            ->setSku($this->sku)
            ->setPrice( round($this->price_with_discount,2));
    }




}
