<?php

namespace App\Http\Controllers\Cltvo;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;

use App\Models\Shop\Discounts\DiscountCode;

use View;
use Auth;

class CltvoTestPagesController extends ClientController
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $test = env("CLTVO_TEST_VIEW");
        $test_view = $test ? $test : "test";

        // $bag = $this->user->bags()->notProtected()->notPaid()->get()->first();
        //
        // dd($bag->bag_totals);

        if (View::exists('cltvo.'.$test_view)) {
            return view('cltvo.'.$test_view);
        }
        abort('404');
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($test_view)
    {
        if (!View::exists('cltvo.' . $test_view))
        {
            abort('404');
        }

        $discount_codes = DiscountCode::all();

        $data = [
            'discount_codes' => $discount_codes
        ];

        return view('cltvo.' . $test_view, $data);
    }
}
