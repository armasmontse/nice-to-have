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

// Route::get('/', function () {
//     return view('home');
// })->name('index');


    Route::group(['prefix' => '{user}' ], function () {

        Route::get('/', 'Users\UserController@show')->name('home');
        Route::patch('/', 'Users\UserController@updateEmail')->name('email.update');
        Route::patch('password', 'Users\UserController@updatePassword')->name('password.update');

        Route::group(['prefix' => 'favoritos', "as" => "wishlist." ], function () {
            Route::get('/', 'Users\WishlistController@index')->name('index');
            Route::group(['middleware' => ['onlyajax'], "as" => "ajax."  ,'prefix' => 'ajax' ], function () {
                Route::resource('/', 'Users\WishlistController',
                    ['only' => ['store',"destroy"],
                    'parameters' => ['' => 'wishlist_product']
                ]);
                // Route::post('{not_in_wishlist_product}', 'Users\WishlistController@index')->name('store');
            });
        });

        Route::group(['prefix' => 'cards', "as" => "cards." ], function () {
            Route::delete('{card}', 'Users\UserController@deleteCard')->name('destroy');
        });

        Route::group(['prefix' => 'bank-accounts', "as" => "bank_accounts." ], function () {
            Route::resource('/', 'Users\BankAccountController', [
                'only' => [ 'create', 'store', 'edit','update','destroy'],
                'parameters' => ['' => 'bank_account']
            ]);
        });

        Route::group(['prefix' => 'eventos', "as" => "events." ], function () {

            // Crear y guardar un nuevo evento personal.
            Route::get('crear', 'Users\Events\PersonalEventsController@create')->name('create');
            Route::post('/', 'Users\Events\PersonalEventsController@store')->name('store');

            // Evento personal creado
            Route::group(['prefix' => '{personal_event}'], function () {

                // Perfil del evento personal
                Route::get('perfil', 'Users\Events\ProfileEventController@index')->name('profile');
                Route::patch('/', 'Users\Events\ProfileEventController@update')->name('update');

                // publicar evento
                Route::patch('publish', 'Users\Events\ProfileEventController@publish')->name('publish');
				Route::patch('finish', 'Users\Events\ProfileEventController@finish')->name('finish');

                // direccion
                Route::patch('address', 'Users\Events\ProfileEventController@address')->name('address');

                // Web del evento personal
                Route::group(['prefix' => 'web', 'as' => 'template.' ], function () {

                    Route::get('/', 'Users\Events\TemplateEventController@index')->name('index');

                    Route::group([ 'middleware' =>  ['onlyajax'] ], function () {
                        Route::patch('/', 'Users\Events\TemplateEventController@update')->name('update');
                    });

                    Route::patch('publish', 'Users\Events\TemplateEventController@publish')->name('publish');

                    Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'middleware' =>  ['onlyajax'] ], function () {
                        Route::patch('header', 'Users\Events\TemplateEventController@header')->name('header');
                        Route::post('photos', 'Users\Events\TemplateEventController@photos')->name('photos');
                    });

                    //secciones del template
                    Route::group(['prefix' => 'secciones', 'as' => 'sections.' ], function () {

                        Route::group(['prefix' => 'ajax', 'as' => 'ajax.', 'middleware' =>  ['onlyajax'] ], function () {

                            Route::patch('sort', 'Users\Events\TemplateSectionsEventController@sortSections')->name('sort');

                            Route::resource('/', 'Users\Events\TemplateSectionsEventController', [
                                'only' => [ 'store', 'update','destroy'],
                                'parameters' => ['' => 'template_section']
                            ]);

                        });

                    });

                });

                // Mensajes y regalos del evento
                Route::get('mensajes-y-regalos', 'Users\Events\ProfileEventController@gifts')->name('gifts');

                // Retiros del evento personal
                Route::group(['prefix' => 'retiro-de-efectivo', 'as' => 'cash-outs.' ], function () {
                    Route::resource('/', 'Users\Events\CashoutsEventController', [
                        'only' => ['index',"store"],
                        'parameters' => ['' => 'personal_event']
                    ]);
                });

                // Estado de cuenta del evento
                Route::get('estado-de-cuenta', 'Users\Events\ProfileEventController@account')->name('account');

                // Carrito
                Route::group(['prefix' => 'carrito', 'as' => 'bag.'], function () {

                    // Show bag
                    Route::get('/', 'Users\Bags\BagEventController@index')->name('index');

                    // Checkout
                    Route::group(['middleware' => ['auth','throttle:60,1'],'prefix' =>  "checkout", 'as' => 'checkout'  ], function ()  {
                        Route::get('/', 'Users\Bags\CheckoutEventController@create')->name(":get");
                        Route::post('/', 'Users\Bags\CheckoutEventController@store')->name(":post");
                    });

                    Route::get('paypal-return', 'Users\Bags\CheckoutEventController@paypalReturn')->name("paypal.return");
                    Route::get('paypal-cancel', 'Users\Bags\CheckoutEventController@paypalCancel')->name("paypal.cancel"); 

                });
            });

            // Route::group(['middleware' => ['onlyajax'], "as" => "ajax."  ,'prefix' => 'ajax' ], function(){
            //
            //     Route::resource('/','Users\Events\PersonalEventsController',[
            //         'only' => [,'update',"destroy"],
            //         'parameters' => ['' => 'personal_event']
            //     ]);
            //
            // });

        });

        // thanks-you page
        Route::group(['prefix' => 'carrito', 'as' => 'bag.'], function () {

			Route::group(['prefix' =>  '{personal_admin_bag}' ], function () {
                // checkout
                Route::group([ 'as' => 'thankyou-page.'  ], function () {
                    Route::get('/', 'Users\Bags\PersonalBagsController@show')->name("show");

                });
            });

            Route::group(['prefix' =>  '{personal_bag}' ], function () {
                // checkout
                Route::group([ 'as' => 'thankyou-page.'  ], function () {
                    Route::get('billing', 'Users\Bags\PersonalBagsController@showBilling')->name("billing:get");
                    Route::post('billing', 'Users\Bags\PersonalBagsController@storeBilling')->name("billing:post");
                });
            });

        });
    });
