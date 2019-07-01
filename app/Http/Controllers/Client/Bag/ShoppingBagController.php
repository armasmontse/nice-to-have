<?php

namespace App\Http\Controllers\Client\Bag;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Http\Requests\Client\Bag\AddToBagRequest;
use App\Http\Requests\Client\Bag\UpdateBagRequest;

use App\Models\Shop\Bag;
use App\Models\Skus\Sku;

use Response;

class ShoppingBagController extends ClientController
{
    public function store(AddToBagRequest $request,Bag $new_bag)
    {
        $this->cookie_bags[$new_bag->bagType->slug] = $new_bag->key;

        $input = $request->all();

        $sku = Sku::where([ "sku" => $input["sku"] ])->get()->first();

        $pivot_args = [
            "shipping_rate" => null,
            "price"         => null,
            "discount"      => null,
            "quantity"      => $input["quantity"]
        ];

        if (!$new_bag->skus()->save($sku,$pivot_args)) {
            return Response::json([
                'bags' => $this->getBagsContent(),
                'error'  => [trans("bag.no_in_bag")]
            ], 422)->withCookie('bags', $this->cookie_bags, 7*60*24)->withCookie('close_bag', $this->event_close_bag ? $this->event_close_bag->key : null, 7*60*24);
        }

        return Response::json([ // todo bien
            'data'      => $sku,
            'bags'    => $this->getBagsContent(),
            'message'   => [trans("bag.in_bag")],
            'success'   => true
        ])->withCookie('bags', $this->cookie_bags, 7*60*24)->withCookie('close_bag', $this->event_close_bag ? $this->event_close_bag->key : null, 7*60*24);
    }

    public function update(UpdateBagRequest $request, Bag $active_bag, Sku $bag_sku )
    {
        $this->cookie_bags[$active_bag->bagType->slug] = $active_bag->key;

        $input = $request->all();

        $pivot_args = [
            "shipping_rate" => null,
            "price"         => null,
            "discount"      => null,
            "quantity"      => $input["quantity"]
        ];

        if (!$active_bag->skus()->updateExistingPivot($bag_sku->sku,$pivot_args)) {
            return Response::json([
                'bags' => $this->getBagsContent(),
                'error'  => [trans("bag.not_update_bag")]
            ], 422)->withCookie('bags', $this->cookie_bags, 7*60*24)->withCookie('close_bag', $this->event_close_bag ? $this->event_close_bag->key : null, 7*60*24);
        }

        return Response::json([ // todo bien
            'data'      => $bag_sku,
            'bags'    => $this->getBagsContent(),
            'message'   => [trans("bag.update_from_bag")],
            'success'   => true
        ])->withCookie('bags', $this->cookie_bags, 7*60*24)->withCookie('close_bag', $this->event_close_bag ? $this->event_close_bag->key : null, 7*60*24);
    }

    public function destroy(Bag $active_bag,Sku $bag_sku  )
    {
        $this->cookie_bags[$active_bag->bagType->slug] = $active_bag->key;

        if (!$active_bag->skus()->detach($bag_sku)) {
            return Response::json([
                'bags' => $this->getBagsContent(),
                'error'  => [trans("bag.not_remove_from_bag")]
            ], 422)->withCookie('bags', $this->cookie_bags, 7*60*24)->withCookie('close_bag', $this->event_close_bag ? $this->event_close_bag->key : null, 7*60*24);
        }

        return Response::json([ // todo bien
            'bags'      => $this->getBagsContent(),
            'message'   => [trans("bag.remove_from_bag")],
            'success'   => true
        ])->withCookie('bags', $this->cookie_bags, 7*60*24)->withCookie('close_bag', $this->event_close_bag ? $this->event_close_bag->key : null, 7*60*24);
    }
}
