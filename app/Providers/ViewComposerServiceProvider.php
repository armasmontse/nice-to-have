<?php

namespace App\Providers;

use Illuminate\Support\ServiceProvider;

class ViewComposerServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot()
    {
    // admin
        view()->composer('layouts.admin', 'App\Http\ViewComposers\AdminLayoutComposer');
        view()->composer('admin.general._menu', 'App\Http\ViewComposers\AdminTopMenuComposer');
        view()->composer('admin.general._sidebar', 'App\Http\ViewComposers\AdminMainMenuComposer');
        view()->composer('admin.pages._basic-info-form', 'App\Http\ViewComposers\Admin\Pages\BasicInfoFormComposer');

    // font
        view()->composer([
            'layouts.client',
            'layouts.splash',
			'layouts.event',
            ], 'App\Http\ViewComposers\ClientLayoutComposer');
        view()->composer('client.menus._menuTop', 'App\Http\ViewComposers\ClientTopMenuComposer');
        view()->composer('client.menus._menuMain', 'App\Http\ViewComposers\ClientMainMenuComposer');
        view()->composer('client.shopping-cart.partials.menu', 'App\Http\ViewComposers\ClientBagsMenuComposer');
        // Authentication
        view()->composer('auth.register', 'App\Http\ViewComposers\ClientRegisterComposer');
        view()->composer('auth.login', 'App\Http\ViewComposers\ClientLoginComposer');

		view()->composer('users.events.cart.summary', 'App\Http\ViewComposers\ClientSummaryComposer');

        // Copys
        view()->composer( [
            'client.events.search.index',
			'client.events.search.search',
            'client.shopping-cart.index',
            'client.checkout.create',
            'client.checkout.partials.payment.spei',
			'client.events.create',
            'client.checkout.thank-you',
            'client.single.vue.modals',

			'users.events.profile',
			'users.events.templates.index',
			'users.events.cashouts.index',
			'users.events.account',
			'users.events.gifts',
            'users.events.cart',
            'users.events.checkout.create',
            'users.events.checkout.partials.payment.spei',

        ], 'App\Http\ViewComposers\ClientCopysComposer');
    // email
        view()->composer('vendor.notifications.email', 'App\Http\ViewComposers\EmailLayoutComposer' );
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
