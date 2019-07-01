<?php

namespace App\Http\Controllers\Client\Shop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Models\Products\Product;

use App\Models\Events\Event;

use Illuminate\Cookie\CookieJar;

use Redirect;

use App\Http\Helpers\CacheHelper;

class ShopController extends ClientController
{
    public function index()
    {

        $cache_products = json_decode(CacheHelper::getCacheByKey("MSProducts"));

        $cache_products = collect( $cache_products ? $cache_products : [] )
            ->map(function($product){
                if (session("cookie_event")) {
                    $product->event_shop_url =  route( 'client::events.shop.single', [session("cookie_event")->slug, $product->slug] );
                } else {
                    $product->event_shop_url = null;
                }
                $product->is_publish = $product->publish_properties->is_publish ? date("Y-m-d") >= $product->publish_properties->publish_at : false;
                return $product;
            });

        if ( !$this->user || !$this->user->hasPermission("manage_products")  ) {
            $cache_products = $cache_products->filter(function($product){
                return $product->is_publish;
            });
        }


        return $cache_products;
    }

    public function show(Product $public_product)
    {
        return $public_product;
    }

    public function showView(Product $public_product)
    {
        return $this->singleView($public_product);
    }

    public function eventView(CookieJar $cookieJar, Event $public_event, Product $public_product)
    {
        if ($this->event_close_bag) {
            return Redirect::to($public_product->client_url)->withErrors([trans("general.blocked_shop.checkout_bag_required")]);
        }

        $cookieJar->queue(cookie('event', $public_event->key, Event::COOKIE_TIME));

        return $this->singleView($public_product);
    }

    protected function singleView(Product $public_product, array $data = [])
    {
        $data = [
            'product'           => $public_product,
            'link_parts'        => $public_product->subcategories->map(function ($subcategory) {
                return [
                    'label'  => $subcategory->label,
                    'link'   => $subcategory->client_url,
                ];
            }),
            'products_in_event' => $this->cookie_event ?  $this->cookie_event->getEventProtectedBagProducts() : collect([]),
            'is_event_shop'     => is_page("client::events.shop.single")
        ];

        return view("client.single.show", $data);
    }
}
