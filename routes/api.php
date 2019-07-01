<?php

use Illuminate\Http\Request;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::group(['prefix' => 'webhooks', "as" => "webhooks." ], function(){

    Route::group(['prefix' => 'conekta', "as" => "conekta." ], function(){
        Route::resource('/','Webhooks\ConektaWebHookController',
            ['only' => ['store', 'index'],
        ]);
    });
});
