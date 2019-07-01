<?php

namespace App\Http\Controllers\Client\Bag;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use App\Http\Requests\Client\ShowPresentsRequest;

use App\Models\Shop\Bag;

use Redirect;


class PresentBagController extends ClientController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Bag $present_bag)
    {
        $data = [
            'present_bag'   => $present_bag,
        ];

        return view('client.presents.index', $data);
    }

    public function auth(Request $request, Bag $present_bag)
    {
        $input = $request->all();
        return Redirect::route('client::presents.show', ['present_bag' => $present_bag->key, 'token' => cltvoMailEncode($input['email'])]);
    }

    public function show(ShowPresentsRequest $request, Bag $present_bag)
    {
        $data = [
            'skus'  => $present_bag->skus,
            'bag'   => $present_bag,
        ];

        return view('client.presents.show', $data);
    }

}
