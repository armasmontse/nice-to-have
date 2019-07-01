
<?php

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of the routes that are handled
| by your application. Just tell Laravel the URIs it should respond
| to using a Closure or controller method. Build something great!
|
*/

Route::group(['domain' => env('URL_SITE')], function () {

    // Authentication Routes...
    Route::get('login', 'Auth\LoginController@showLoginForm')->name('login:get');
    Route::post('login', 'Auth\LoginController@login')->name('login:post');
    Route::post('logout', 'Auth\LoginController@logout')->name('logout');

    // Registration Routes...
    Route::get('register', 'Auth\RegisterController@showRegistrationForm')->name('register:get');
    Route::post('register', 'Auth\RegisterController@register')->name('register:post');


    // Password Reset Routes...
    Route::get('password/reset', 'Auth\ForgotPasswordController@showLinkRequestForm')->name('pass_reset:get');
    Route::post('password/email', 'Auth\ForgotPasswordController@sendResetLinkEmail')->name('pass_reset_email');
    Route::get('password/reset/{token}', 'Auth\ResetPasswordController@showResetForm')->name('pass_reset_token');
    Route::post('password/reset', 'Auth\ResetPasswordController@reset')->name('pass_reset:post');

    // set firstime Password
    Route::get('password/set/{user_email}', 'Auth\SetPasswordController@edit')->name('pass_set:get');
    Route::patch('password/set/{user_email}', 'Auth\SetPasswordController@update')->name('pass_set:patch');

    // facebook login
    Route::get('login/facebook', 'Auth\FacebookController@redirectToProvider')->name('login.facebook');
    Route::get('login/facebook/callback', 'Auth\FacebookController@handleProviderCallback')->name('login.facebook.callback');

    // shop
    Route::group(['prefix' => 'productos' ,"as" => "single." ], function(){
        Route::get('{public_product}', 'Client\Shop\ShopController@showView')->name('show');
        Route::group(['middleware' => ['onlyajax'], "as" => "ajax."  ,'prefix' => 'ajax' ], function(){
            Route::get('{public_product}', 'Client\Shop\ShopController@show')->name('show');
        });
    });

    // Tienda
    Route::group(['prefix' => 'tienda', "as" => "shop."  ], function(){

            Route::get('/', 'Client\Shop\FilterShopController@index')->name('index');

            Route::group(['middleware' => ['onlyajax'], "as" => "ajax."  ,'prefix' => 'ajax' ], function(){
                Route::get('/', 'Client\Shop\ShopController@index')->name('index');
            });

            Route::group(["as" => "filters."  ], function(){

                Route::group(['prefix' => 'categorias'  ], function(){
                    Route::get('{public_category}', 'Client\Shop\FilterShopController@category')->name('category');
                    Route::get('{public_category}/{public_subcategory}', 'Client\Shop\FilterShopController@subcategory')->name('subcategory');
                });

                Route::group(['prefix' => 'tipos-de-evento'  ], function(){
                    Route::get('{public_type}', 'Client\Shop\FilterShopController@type')->name('type');
                    Route::get('{public_type}/{public_subtype}', 'Client\Shop\FilterShopController@subtype')->name('subtype');
                });

            });

    });


    // client services

    Route::group(['middleware' => ['onlyajax'], "as" => "micro_services."  ,'prefix' => 'microservices' ], function(){
        // cateorias

            Route::group(['prefix' => 'categories', "as" => "categories." ], function(){
                Route::get( "/" , 'Client\MicroServices\ServiceCategoriesController@index')->name("index");
            });

        // sub cateorias
            Route::group(['prefix' => 'subcategories', "as" => "subcategories." ], function(){
                Route::get( "/" , 'Client\MicroServices\ServiceSubcategoriesController@index')->name("index");
            });

        // tipos
            Route::group(['prefix' => 'types', "as" => "types." ], function(){
                Route::get( "/" , 'Client\MicroServices\ServiceTypesController@index')->name("index");
            });

        // sub subtipos
            Route::group(['prefix' => 'subtypes', "as" => "subtypes." ], function(){
                Route::get( "/" , 'Client\MicroServices\ServiceSubtypesController@index')->name("index");

            });
    });

    Route::group(['prefix' => 'carritos', 'as' => 'bags.'], function () {

        Route::resource('/','Client\Bag\BagsController',[
            'only' => ["index"],
        ]);
    });

    Route::group(['prefix' => 'carrito', 'as' => 'bag.'], function () {

        Route::group(['prefix' =>  '{new_bag}' ], function () { // falta medewlware

            Route::group(['middleware' => ['onlyajax'], "as" => "ajax."  ,'prefix' => 'ajax' ], function(){

                Route::resource('/','Client\Bag\ShoppingBagController',[
                    'only' => ["store"],
                ]);

            });
        });

        Route::group(['prefix' =>  '{active_bag}' ], function () { // falta medewlware

            // checkout
            Route::group(['middleware' => ['auth','throttle:60,1'],'prefix' =>  "checkout", 'as' => 'checkout'  ], function ()  {
                Route::get('/', 'Client\Bag\CheckoutController@create')->name(":get");
                Route::post('/', 'Client\Bag\CheckoutController@store')->name(":post");
            });

            Route::get('paypal-return', 'Client\Bag\CheckoutController@paypalReturn')->name("paypal.return");
            Route::get('paypal-cancel', 'Client\Bag\CheckoutController@paypalCancel')->name("paypal.cancel");

            // checkout
            Route::group(['middleware' => ['anonymous'],'prefix' =>  "checkout", 'as' => 'checkout'  ], function ()  {
                Route::get('ingresar', 'Client\Bag\CheckoutController@login')->name(".register");
            });

            Route::group(['middleware' => ['onlyajax'], "as" => "ajax."  ,'prefix' => 'ajax' ], function(){
                // Route::post('address', 'Bag\AddressValidationController@check');
                Route::resource('/','Client\Bag\ShoppingBagController',[
                    'only' => ['update','destroy'],
                    'parameters' => ['' => 'bag_sku']
                ]);

                Route::post('validate-discount-code', 'Client\Bag\DiscountCodesController@validateDiscountCode')->name('validateDiscountCode');
            });

        });

    });

    Route::group(['prefix' => 'para-ti', 'as' => 'presents.'], function () {

        Route::group(['prefix' =>  '{present_bag}' ], function () { // falta medewlware
            Route::get('/auth', 'Client\Bag\PresentBagController@index')->name("index");
            Route::post('/auth', 'Client\Bag\PresentBagController@auth')->name("auth");
            Route::get('/', 'Client\Bag\PresentBagController@show')->name("show");
        });

    });

    // mesas de regalos
    Route::group(['prefix' => 'mesas-de-regalos', 'as' => 'events.'], function () {
        Route::get( 'buscar' , 'Client\Events\SearchEventsController@search')->name("search");
        Route::get('{public_event}', 'Client\Shop\FilterShopController@event')->name('shop');
        Route::get('{public_event}/{public_product}', 'Client\Shop\ShopController@eventView')->name('shop.single');
    });

	// Route::group([ 'prefix' => 'info', "as" => "info."  ], function(){
	// 	Route::resource('/','Client\Pages\InfoController',[
	// 		'only' => ['show'],
	// 		'parameters' => ['' => 'info_page_slug']
	// 	]);
	// });

    Route::group(['prefix' => 'eventos', 'as' => 'event.', 'middleware' => ['anonymous']], function () {
        Route::get( 'ingresar' , 'Client\Events\EventController@register')->name("register");
    });

    // Alternas
    Route::group(['prefix' => 'evento/{public_event_with_template}', 'as' => 'events-alt.'], function () {
        Route::get( '/' , 'Client\Events\EventController@show')->name("show");
        Route::post( "confirm" , 'Client\Events\EventController@confirmAttendance')->name("confirm");
        Route::get( "set" , 'Client\Events\EventController@setCookie')->name("set");
    });

    // Page Routas
    Route::group([ "as" => 'pages.'], function(){
        Route::resource('/','Client\PagesController', [
            'only'          => [ 'index', 'show'],
            'parameters'    => ['' => 'public_page']
        ]);

        Route::get('{public_page}/{public_child_page}', 'Client\PagesController@showChild')->name('showChild');
    });

    Route::post('contacto', 'Client\PagesController@contacto')->name('pages.contacto:post');
});

//Rutas para los eventos
Route::group(['domain' => '{public_event_with_template}.'.env('URL_SITE'), 'as' => 'events.'], function () {
    Route::get( "/" , 'Client\Events\EventController@show')->name("show");
    Route::post( "confirm" , 'Client\Events\EventController@confirmAttendance')->name("confirm");
    Route::get( "set" , 'Client\Events\EventController@setCookie')->name("set");
});
