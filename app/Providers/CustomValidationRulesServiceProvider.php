<?php

namespace App\Providers;

use App\Http\Helpers\EstafetaShipmentsHelper as Shipment;

use Illuminate\Support\ServiceProvider;

use App\Models\Shop\Discounts\DiscountCode;
use App\Models\Products\Product;
use App\Models\Shop\BagStatus;
use App\Models\Events\Event;
use App\Models\Shop\BagUser;
use App\Models\Shop\BagType;
use App\Models\Skus\Sku;
use App\Models\Shop\Bag;
use App\User;

use Validator;
use Hash;
use DB;

class CustomValidationRulesServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
        Validator::extendImplicit('password_check', function ($attribute, $value, $parameters, $validator) {
            return Hash::check($value, $parameters[0]);
        });

        Validator::extendImplicit('not_default_sku', function ($attribute, $value, $parameters) {
            return DB::table("skus")
                ->where(["product_id" => $parameters[0], "default" => true])
                ->count()<1;
        });

        Validator::extendImplicit('present_if', function ($attribute, $value, $parameters, $validator) {
            $data = $validator->getData();
            if (isset($data[$parameters[0]]) && $data[$parameters[0]] == $parameters[1]) {
                return array_has($data, $attribute)  ;
            }
            return true;
        });

        Validator::extendImplicit('published', function ($attribute, $value, $parameters, $validator) {
            if ($parameters[0] == 'sku') {
                return Sku::where(["sku" => $value])->with('product')->whereHas('product', function ($q) {
                    return $q->Public();
                })->count() > 0;
            } elseif ($parameters[0] == 'product') {
                return Product::public()->where([ 'id' => $value ])->count() > 0;
            } else {
                return false;
            }
        });

        Validator::extendImplicit('not_related_with', function ($attribute, $value, $parameters, $validator) {
            // $product = Product::find($value);
            // $user = User::find($parameters[0]);
            // return !$user->isRelatedWith($product);
            return User::where(['id' => $parameters[0]])->with('products')->whereHas('products', function ($query) use ($value) {
                return $query->where(['id' => $value]);
            })->count() == 0;
        });

        Validator::extendImplicit('not_in_bag', function ($attribute, $value, $parameters, $validator) {
            // $bag = Bag::find($parameters[0]);
            // $sku = Sku::find($value);
            // return !$bag->inBag($sku);

            return Bag::where(['id' => $parameters[0]])->with('skus')->whereHas('skus', function ($query) use ($value) {
                return $query->where([ "sku" => $value ]);
            })->count() == 0;
        });

        Validator::extendImplicit('product_not_in_event', function ($attribute, $value, $parameters, $validator) {
            $event = Event::find($parameters[0]);
            $sku = Sku::find($value);
            return !($event->getEventProtectedBagProducts()->contains($sku->product));
        });

        Validator::extendImplicit('is_bag_friend_email', function ($attribute, $value, $parameters, $validator) {
            return Bag::with('bagShipping', 'bagShipping.address')
                    ->where('key', $parameters[0])
                    ->whereHas('bagShipping.address', function ($query) use ($value) {
                        $query->where('email', cltvoMailDecode($value));
                    })
                    ->first();
        });

        Validator::extendImplicit('is_valid_status_for_type', function ($attribute, $value, $parameters, $validator) {
            $bagType = BagType::findOrFail($parameters[0]);

            if (!$bagType->event && !$bagType->especial && !$bagType->protected) {          // Es bolsa personal.
                return true;
            } elseif ($bagType->event && !$bagType->especial && !$bagType->protected) {     // Agregar a mesa de regalos
                $bagStatus = BagStatus::findOrFail($value);
                return ($bagStatus->slug == 'pagado' || $bagStatus->slug == 'cancelado') ? true: false;
            } elseif ($bagType->event && $bagType->especial && !$bagType->protected) {      // Retirar mesa de regalos
                $bagStatus = BagStatus::findOrFail($value);
                return $bagStatus->slug != 'cancelado' ?  true : false;
            } elseif ($bagType->event && $bagType->especial && $bagType->protected) {       // Mesa de regalos protegida
                return false;
            }

            return false;
        });

        // El código de descuento no existe
        Validator::extendImplicit('discount_code_exists', function ($attribute, $value, $parameters, $validator)
        {
            if(!DiscountCode::where('code', $value)->first())
            {
                return false;
            }

            return true;
        });

        // El código de descuento no está vigente
        Validator::extendImplicit('discount_code_valid', function ($attribute, $value, $parameters, $validator)
        {
            $discount_code = DiscountCode::where('code', $value)->first();

            if(!$discount_code->inTime)
            {
                return false;
            }

            return true;
        });

        // El código de descuento ya fue utilizado
        Validator::extendImplicit('discount_code_not_used', function ($attribute, $value, $parameters, $validator)
        {
            $discount_code = DiscountCode::where('code', $value)->first();

            if($discount_code->unique && $discount_code->bags()->get()->count() > 0)
            {
                return false;
            }

            return true;
        });

        Validator::extendImplicit('youtube_video_url', function ($attribute, $value, $parameters, $validator) {
            return is_youtube_url($value);
        });

        Validator::extendImplicit('google_maps_url', function ($attribute, $value, $parameters, $validator) {
            return is_google_maps_url($value);
        });

		Validator::extendImplicit('no_scripts', function ($attribute, $value, $parameters, $validator) {

			$lower_case_value = strtolower(  clear_string( $value ) );

			preg_match("/\<\s*script.*\>/", $lower_case_value,$open_scrip_matches );
			preg_match("/\<\s*\/\s*script\s*\>/", $lower_case_value,$close_scrip_matches );

			return empty($open_scrip_matches) && empty($close_scrip_matches);

		});
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
    }
}
