<?php

namespace App\Http\Controllers\Client\Pages;

use Illuminate\Http\Request;

use App\Http\Requests;
use App\Http\Controllers\ClientController;
use View;

class InfoController extends ClientController
{

    public function index( )
    {
        return view("client.info.index");
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($info_page_slug)
    {

        if (View::exists('client.info.'.$info_page_slug)) {
            return view('client.info.'.$info_page_slug);
        }
		abort('404');
    }

}
