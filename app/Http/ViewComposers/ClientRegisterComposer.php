<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Route;

use App\Setting;
use Auth;

class ClientRegisterComposer
{
	public function compose(View $view)
	{
		$register = '';

		if ( is_page('client::register:get'))
		{
			$image = Setting::getRegisterImage()->thumbnail_image;
			$register = 'main_register';
		}
		elseif ( is_page('client::bag.checkout.register'))
		{
			$image = Setting::getCheckoutRegisterImage()->thumbnail_image;
			$register = 'checkout_register';
		}
		elseif (is_page('client::event.register'))
		{
			$image = Setting::getEventRegisterImage()->thumbnail_image;
			$register = 'event_register';
		}

		$view->with('background_url', isset($image->url) ? $image->url : null);
		$view->with('register_copy', Setting::getAuthenticationCopy($register));
	}
}
