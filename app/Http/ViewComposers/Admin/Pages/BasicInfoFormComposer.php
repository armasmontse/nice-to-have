<?php
namespace App\Http\ViewComposers\Admin\Pages;

use Illuminate\Contracts\View\View;

use App\Models\Pages\Page;
use App\Publish;

class BasicInfoFormComposer
{

	public function compose(View $view)
	{
		$view->with('pages_list',  Page::with([
				"languages"
			])
			->notMain()
			->whereNull('parent_id')
			->orderBy('index', 'ASC')
			->get()
			->pluck('index','id')
		);

		$view->with("publishes_list", Publish::get()->pluck('label','id') );
	}
}
