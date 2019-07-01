<?php

namespace App\Http\Controllers\Client\Shop;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Models\Products\Category;
use App\Models\Products\Subcategory;
use App\Models\Events\Subtype;
use App\Models\Events\Type;

use App\Models\Events\Event;

use Redirect;
use Illuminate\Cookie\CookieJar;

class FilterShopController extends ClientController
{
    public function index()
    {
        return $this->girdView();
    }

    public function category(Category $public_category)
    {
        $data = [
            "object"            => $public_category,
            "subcategories"     => $public_category->subcategories->pluck("id")->toArray()
        ];

        return $this->girdView($data);
    }

    public function subcategory(Category $public_category, Subcategory $public_subcategory)
    {
        $data = [
            "object"            => $public_subcategory,
            "subcategories"     => [$public_subcategory->id]
        ];

        return $this->girdView($data);
    }

    public function type(Type $public_type)
    {
        $data = [
            "object"       => $public_type,
            "subtypes"     => $public_type->subtypes->pluck("id")->toArray()
        ];

        return $this->girdView($data);
    }

    public function subtype(Type $public_type, Subtype $public_subtype)
    {
        $data = [
            "object"       => $public_subtype,
            "subtypes"     => [$public_subtype->id]
        ];

        return $this->girdView($data);
    }

    public function event(CookieJar $cookieJar,Event $public_event)
    {
        $cookieJar->queue(cookie('event',$public_event->key, Event::COOKIE_TIME));

        $data = [
            "object"       => $public_event->typeable,
            "subtypes"     => $public_event->typeable ? ( $public_event->typeable->object_type == "type" ? $public_event->typeable->subtypes->pluck("id")->toArray() : [$public_event->typeable->id] ): []
        ];

        return $this->girdView($data);
    }

    /**
     * display shop view grid
     * @param  array  $data data for view
     * @return \Illuminate\Http\Response
     */
    private function girdView(array $data = [])
    {
        $data["subcategories"] = $this->getRouteFilters("subcategories", $data);

        $data["subtypes"] = $this->getRouteFilters("subtypes", $data);

        $data["link_parts"][] = [
            "label"  => "tienda",
            "link"   => route("client::shop.index"),
        ];

        $data["is_event_shop"] = is_page("client::events.shop");

        if (isset($data["object"])) {

            if (in_array($data["object"]->object_type, ["subtype", "subcategory"])) {

                $data["link_parts"][] = [
                    "label"  => $data["object"]->parent_label,
                    "link"   => $data["object"]->parent_client_url,
                ];

            }

            $data["link_parts"][] = [
                "label"  => $data["object"]->label,
                "link"   => $data["object"]->client_url,
            ];

        }

        return view("client.shop.main", $data);
    }

    /**
     * get filters form the get request for a esecific key
     * @param  strig $key key to array with data
     * @return array      data
     */
    private function getFilterFromGetParameters($key)
    {
        $filters = request()->all();

        if (isset($filters[$key]) && is_array($filters[$key])) {

            return array_map(function($subcategory){
                return intval($subcategory);
            }, $filters[$key]);

        }

        return [];
    }

    /**
     * get the filters for the route
     * @param  strig $key key to array with data
     * @param  array  $data data for view
     * @return array  filters
     */
    private function getRouteFilters($key, $data)
    {
        $filters = $this->getFilterFromGetParameters($key);

        if ($key == "subtypes" && $this->cookie_event && is_page("client::events.shop")) {

            if ($this->cookie_event->typeable->object_type == "subtype") {
                return [$this->cookie_event->typeable->id];
            }

            return $this->cookie_event->typeable->subtypes->map(function($subtype){
                return $subtype->id;
            });
        }

        if (!empty($filters) ) {
            return $filters;
        }

        return  isset($data[$key]) ? $data[$key] : [];
    }
}
