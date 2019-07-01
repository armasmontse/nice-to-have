<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use App\Setting;
use Auth;

class ClientSummaryComposer
{
	public function compose(View $view)
	{

		$view->with('checkout_min_percentage', Setting::getCheckoutMinPercentage());
	}
}
