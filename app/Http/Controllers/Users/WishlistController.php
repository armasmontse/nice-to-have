<?php

namespace App\Http\Controllers\Users;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\User;
use App\Models\Products\Product;

use App\Http\Requests\Users\Wishlist\AddToWishlistRequest;

use Response;

class WishlistController extends ClientController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(User $user)
    {
        $data = [
            "products" => $user->products()->with("skus")->get(),
            "products_in_event" => $this->cookie_event ?  $this->cookie_event->getEventProtectedBagProducts() : collect([]),
        ];
        return view('users.wishlist.index',$data);
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(AddToWishlistRequest $request,User $user )
    {
        $input = $request->all();

        $product = Product::find($input["favorite_id"]);

        if (!$user->products()->save($product)) {
            return Response::json([
                'error' => [trans('wishlist.errors.add')]
            ], 422);
        }

        return Response::json([ // todo bien
            'message' => [trans('wishlist.success.add')],
            'success' => true
        ]);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(User $user, Product $wishlist_product)
    {
        if (!$user->products()->detach($wishlist_product)) {
            return Response::json([
                'error' => [trans('wishlist.errors.delete')]
            ], 422);
        }

        return Response::json([ // todo bien
            'message' => [trans('wishlist.success.delete')],
            'success' => true
        ]);
    }
}
