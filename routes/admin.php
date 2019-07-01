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


    // principles
    Route::get('/', 'Admin\AdminController@index')->name('index');

    Route::get('manuals', 'Admin\AdminController@manuals')->name('manuals');
    //mapa de rutas
    Route::group(['middleware' => ['permission:routes_view'] ], function(){
        Route::get('site-map', 'Admin\AdminController@siteMap')->name('site_map');
    });

    //administrador de settings

    Route::group(['prefix' => 'cache', 'as' => 'cache.' ], function(){
        Route::patch('update', 'Admin\Cache\ManageCacheController@update')->name('update');
    });

    //administrador de settings
    Route::group(['middleware' => ['permission:system_config'] ,'prefix' => 'settings', 'as' => 'settings.' ], function(){

        Route::resource('/','Admin\Settings\ManageSettingController',[
            'only'       => [ 'index', 'update'],
            'parameters' => ['' => 'setting_key']
        ]);

    });

    //administracion de usuarios
    Route::group(['middleware' => ['permission:manage_users'] ,'prefix' => 'users', 'as' => 'users.'  ], function(){

        Route::resource('/','Admin\Users\ManageUserController',[
            'only'       => ['index','create','edit','store','update'],
            'parameters' => ['' => 'user_editable']
        ]);

        Route::resource('/','Admin\Users\ManageUserController',[
            'only'       => ['destroy'],
            'parameters' => ['' => 'erasable_user']
        ]);

        Route::get( 'trash' , 'Admin\Users\ManageUserController@trash')->name('trash');

        Route::patch( 'trash/{user_trashed}' , 'Admin\Users\ManageUserController@recovery')->name('recovery');

    });

    // media manager
    Route::group(['middleware' => ['permission:manage_photos'] ,'prefix' => 'photos', 'as' => 'photos.' ], function(){

        Route::group(['middleware' => ['permission:photos_view']  ], function(){
            Route::get( '/' , 'Admin\Photos\ManagePhotosController@indexView')->name('index');
        });

        Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.'  ,'prefix' => 'ajax' ], function(){

            Route::resource('/','Admin\Photos\ManagePhotosController',[
                'only' => ['index','edit','store','update','destroy'],
                'parameters' => ['' => 'photo']
            ]);

            Route::post( '{photo}/associate' , 'Admin\Photos\ManagePhotosController@associate')->name('associate');

            Route::delete( '{photo}/disassociate' , 'Admin\Photos\ManagePhotosController@disassociate')->name('disassociate');

            Route::patch( 'update/sort' , 'Admin\Photos\ManagePhotosController@sort')->name('sort');

        });

    });

    // Páginas
    Route::group(['prefix' => 'pages', 'as' => 'pages.'], function(){

        // Rutas para editar el content
        Route::group(['middleware' => ['permission:manage_pages_contents']], function(){

            Route::patch('sort' , 'Admin\Pages\ManagePagesContentsController@sort')->name('sort');
            Route::group(['prefix' => 'contents', 'as' => 'contents.'], function(){

                Route::resource('/','Admin\Pages\ManagePagesContentsController', [
                    'only'          => ['index', 'edit'],
                    'parameters'    => ['' => 'page_edit_content']
                ]);
                Route::resource('/','Admin\Pages\ManagePagesController', [
                    'only'          => ['update'],
                    'parameters'    => ['' => 'page_edit']
                ]);
            });

            Route::group(['prefix' => 'sections', 'as' => 'sections.' ], function(){

                Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.', 'prefix' => 'ajax'], function(){

                    Route::group(['prefix' => '{page_section}'  ], function(){

                        Route::group([ 'as' => 'components.', 'prefix' => 'components'  ], function(){
                            Route::patch( 'sort' , 'Admin\Pages\ManagePagesComponentsController@sort')->name('sort');

                            Route::resource('/','Admin\Pages\ManagePagesComponentsController', [
                                'only'          => ['store','update','destroy'],
                                'parameters'    => ['' => 'section_component']
                            ]);
                        });
                    });
                });
            });
        });

        // Rutas para el manejo de paginas
        Route::group(['middleware' => ['permission:manage_pages']], function(){

        // Crud de paginas
            Route::resource('/','Admin\Pages\ManagePagesController',[
                'only'          => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
                'parameters'    => ['' => 'page_edit']
            ]);

            Route::group(['as' => 'sections.'], function(){

                // Para asociar y ortear secciones de una pagina
                Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.', 'prefix' => '{page_edit}/sections'], function(){
                    Route::patch('{page_section}/association' , 'Admin\Pages\ManagePagesController@sectionAssociation')->name('association');
                    Route::patch('sort' , 'Admin\Pages\ManagePagesController@sort')->name('sort');
                });

                Route::group(['prefix' => 'sections'], function(){
                    Route::get('/' , 'Admin\Pages\ManagePagesSectionsController@indexView')->name('index');

                    Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.'  ,'prefix' => 'ajax'], function(){
                        Route::resource('/','Admin\Pages\ManagePagesSectionsController',[
                            'only'          => ['index', 'store', 'update', 'destroy'],
                            'parameters'    => ['' => 'page_section']
                        ]);
                    });
                });
            });
        });
    });

    // provedores
    Route::group(['middleware' => ['permission:manage_providers'] ,'prefix' => 'providers', 'as' => 'providers.' ], function(){

        Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.'  ,'prefix' => 'ajax' ], function(){
            Route::resource('/','Admin\Products\ManageProvidersController',[
                'only'       => ['index','store','update','destroy'],
                'parameters' => ['' => 'provider']
            ]);
        });

        Route::get( '/' , 'Admin\Products\ManageProvidersController@indexView')->name('index');
        Route::get('{provider}', 'Admin\Products\ManageProvidersController@show')->name('show');
    });

    // tipos
    Route::group(['middleware' => ['permission:manage_types'] ,'prefix' => 'types', 'as' => 'types.' ], function(){

        Route::get( '/' , 'Admin\Events\ManageTypesController@indexView')->name('index');

        Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.'  ,'prefix' => 'ajax' ], function(){

            Route::resource('/','Admin\Events\ManageTypesController',[
                'only'       => ['index','store','update','destroy'],
                'parameters' => ['' => 'type']
            ]);

        });

    });

    // sub subtipos
    Route::group(['middleware' => ['permission:manage_subtypes'] ,'prefix' => 'subtypes', 'as' => 'subtypes.' ], function(){

        Route::get( '/' , 'Admin\Events\ManageSubtypesController@indexView')->name('index');

        Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.'  ,'prefix' => 'ajax' ], function(){

            Route::resource('/','Admin\Events\ManageSubtypesController',[
                'only'       => ['index','store','update','destroy'],
                'parameters' => ['' => 'subtype']
            ]);

        });

    });

    // cateorias
    Route::group(['middleware' => ['permission:manage_categories'] ,'prefix' => 'categories', 'as' => 'categories.' ], function(){

        Route::get( '/' , 'Admin\Products\ManageCategoriesController@indexView')->name('index');

        Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.'  ,'prefix' => 'ajax' ], function(){

            Route::resource('/','Admin\Products\ManageCategoriesController',[
                'only'       => ['index','store','update','destroy'],
                'parameters' => ['' => 'category']
            ]);

        });

    });

    // sub cateorias
    Route::group(['middleware' => ['permission:manage_subcategories'] ,'prefix' => 'subcategories', 'as' => 'subcategories.' ], function(){

        Route::get( '/' , 'Admin\Products\ManageSubcategoriesController@indexView')->name('index');

        Route::group(['middleware' => ['onlyajax'], 'as' => 'ajax.'  ,'prefix' => 'ajax' ], function(){

            Route::resource('/','Admin\Products\ManageSubcategoriesController',[
                'only'       => ['index','store','update','destroy'],
                'parameters' => ['' => 'subcategory']
            ]);

        });

    });

    //administracion de productos
    Route::group(['middleware' => ['permission:manage_products'] ,'prefix' => 'products', 'as' => 'products.'  ], function(){

        Route::resource('/','Admin\Products\ManageProductsController',[
            'only'          => ['create','edit','store','update'],
            'parameters'    => ['' => 'product_editable']
        ]);

        Route::get( '/' , 'Admin\Products\ManageProductsController@indexView')->name('index');

        Route::resource('/','Admin\Products\ManageProductsController',[
            'only'       => ['destroy'],
            'parameters' => ['' => 'erasable_product']
        ]);

        Route::group(['middleware' => ['onlyajax'],'prefix' => 'ajax','as' => 'ajax.' ], function(){

            Route::resource('/','Admin\Products\ManageProductsController',[
                'only'       => ['index','show'],
                'parameters' => ['' => 'product_editable']
            ]);

        });

        Route::get( 'trash' , 'Admin\Products\ManageProductsController@trash')->name('trash');

        Route::patch( 'trash/{product_trashed}' , 'Admin\Products\ManageProductsController@recovery')->name('recovery');

        Route::group(['prefix' => '{product_editable}' ], function(){

            // secciones
            Route::group(['middleware' => ['onlyajax'],'prefix' => 'secciones/ajax','as' => 'secciones.ajax.' ], function(){

                Route::resource('/','Admin\Products\ManageProductSectionsController',[
                    'only'       => ['index','store','update','destroy'],
                    'parameters' => ['' => 'product_section']
                ]);

            });

            // skus
            Route::group(['middleware' => ['onlyajax'],'prefix' => 'skus/ajax','as' => 'skus.ajax.' ], function(){

                Route::resource('/','Admin\Skus\ManageSkusController',[
                    'only'       => ['index','store','update','destroy'],
                    'parameters' => ['' => 'product_sku']
                ]);

            });

            // subcategories
            Route::group(['middleware' => ['onlyajax'],'prefix' => 'subcategories/ajax','as' => 'subcategories.ajax.' ], function(){

                Route::patch( '{subcategory}' , 'Admin\Products\ManageProductRelationsController@updateSubcategory')->name('update');

            });

            // subtipos
            Route::group(['middleware' => ['onlyajax'],'prefix' => 'subtypes/ajax','as' => 'subtypes.ajax.' ], function(){

                Route::patch( '{subtype}' , 'Admin\Products\ManageProductRelationsController@updateSubtype')->name('update');

            });

            // productos relacionados
            Route::group(['middleware' => ['onlyajax'],'prefix' => 'related-products/ajax','as' => 'related-products.ajax.' ], function(){

                Route::patch( '/' , 'Admin\Products\ManageProductRelationsController@updateProduct')->name('update');

            });

        });

    });

    //administracion de eventos
    Route::group(['middleware' => ['permission:manage_events'] ,'prefix' => 'events', 'as' => 'events.'  ], function(){

        Route::resource('/','Admin\Events\ManageEventsController',[
            'only'       => ['index', 'show', 'update', 'delete'],
            'parameters' => ['' => 'event']
        ]);

    });

    //administracion de retiros
    Route::group(['middleware' => ['permission:manage_cashouts'] ,'prefix' => 'cashouts', 'as' => 'cashouts.'  ], function(){

        Route::get( '/' , 'Admin\Events\ManageCashoutsController@index')->name('index');

        // status
        Route::group(['middleware' => ['onlyajax'], 'prefix' => 'status/ajax','as' => 'status.ajax.' ], function(){

            Route::patch( '{cashout}' , 'Admin\Events\ManageCashoutsController@update')->name('update');

        });

    });

    // Administración de bolsas
    Route::group(['middleware' => ['permission:manage_bags'] ,'prefix' => 'bags', 'as' => 'bags.'  ], function(){

        // Mostrar bolsa
        Route::get('/' , 'Admin\Bags\ManageBagsController@index')->name('index');
        Route::get('show/{personal_admin_bag}' , 'Users\Bags\PersonalBagsController@show')->name('show');

        // Editar bolsa
        Route::get('edit/{admin_payed_bag}', 'Admin\Bags\ManageBagsController@edit')->name('edit');

        // Billings
        Route::group(['prefix' => 'billing','as' => 'billing.' ], function(){
            Route::patch( '{admin_payed_bag}' , 'Admin\Bags\ManageBagsController@updateBilling')->name('update');
        });

        // Status
        Route::group(['prefix' => 'status','as' => 'status.' ], function(){
            Route::patch( '{admin_payed_bag}' , 'Admin\Bags\ManageBagsController@updateStatus')->name('update');
        });

        // Shipping
        Route::group(['prefix' => 'shipping','as' => 'shipping.' ], function(){
            Route::patch( '{admin_payed_bag}' , 'Admin\Bags\ManageBagsController@updateShipping')->name('update');
        });

    });

    // Administrador de códigos de descuento
    Route::group(['middleware' => ['permission:manage_discount_codes'], 'prefix' => 'discount_codes', 'as' => 'discount_codes.'], function()
    {
        Route::resource('/', 'Admin\Discounts\ManageDiscountCodesController', [
            'only'       => ['index', 'create', 'store', 'edit', 'update', 'destroy'],
            'parameters' => ['' => 'discount_code']
        ]);

        Route::get('trash', 'Admin\Discounts\ManageDiscountCodesController@trash')->name('trash');
        Route::patch('trash/{discount_code_trashed}', 'Admin\Discounts\ManageDiscountCodesController@recovery')->name('recovery');
    });
