<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use App\Setting;
use Auth;

class ClientLoginComposer
{
	public function compose(View $view)
	{
		$image = Setting::getLoginImage()->thumbnail_image;
		
		if (isset($image->url))
		{ 
			$view->with('background_url', $image->url);
		}

		$view->with('login_copy', Setting::getAuthenticationCopy('login'));
	}
}
