<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use Auth;

class ClientTopMenuComposer
{
	public function compose(View $view)
	{
		$view->with('user', Auth::user() );
	}
}
