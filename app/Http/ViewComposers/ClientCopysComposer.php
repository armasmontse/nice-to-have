<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use App\Setting;
use App;
use Auth;

class ClientCopysComposer
{
	public function compose(View $view)
	{
		$iso = session('lang') ? session('lang') : App::getLocale();
        $copys_form_setting = Setting::getPagesCopys();
		$copys_form_setting = is_array($copys_form_setting) ? $copys_form_setting : [];

		$copys_array  = collect(Setting::SITE_COPYS_ARRAY);
		$show_empty_copy = Auth::user() && Auth::user()->hasPermission('system_config');

		foreach ($copys_array as $page => $copys_for_page) {
			foreach ($copys_for_page as $copy) {
				$key = $page . '_' . $copy ;
				$text_copy = array_get($copys_form_setting, $key. '.' . $iso);
	        	$view->with($key."_copy", $show_empty_copy && empty($text_copy) ? trans('general.no_description')  :  clean_classes_and_inline_styles($text_copy) );
			}
		}
	}
}
