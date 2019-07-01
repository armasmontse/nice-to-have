<?php
namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;

use App\Models\Pages\Page;
use App\Models\Seo\Seo;
use App\Setting;
use Auth;

use Illuminate\Support\Facades\Route;

class ClientLayoutComposer
{
	public function compose(View $view)
	{
		$view->with('user', Auth::user() );

        $social_networks = Setting::getSocialNetworks();
		$view->with('social_networks', $social_networks);

        $blog_link = Setting::getBlog();
		$view->with('blog', $blog_link);

		$view->with('pages_footer', Page::where('index', 'terminos-y-condiciones')->orWhere('index', 'aviso-de-privacidad')->orWhere('index', 'preguntas-frecuentes')->orderBY('order', 'asc')->get());

		if (is_page('client::pages.show')) {

			$currentRoute = Route::current();
			$params = $currentRoute->parameters();
			$page = $params['public_page'];
			$seo = Seo::createSeo($page ? $page->label : null );

		}elseif (is_page('client::single.show') || is_page('client::events.shop.single')) {

			$currentRoute = Route::current();
			$params = $currentRoute->parameters();
			$product = $params['public_product'];
			$seo = $product ? Seo::createSeo($product->title, $product->description, isset ($product->default_sku->thumbnail_image->url) ? $product->default_sku->thumbnail_image->url : null) : Seo::createSeo();

		}elseif (is_page('client::events.show') || is_page('client::events-alt.show')) {

			$currentRoute = Route::current();
			$params = $currentRoute->parameters();
			$event = $params['public_event_with_template'];
			$seo = $event ? Seo::createSeo($event->name, $event->description, isset($event->thumbnail_image->url) ? $event->thumbnail_image->url : null ) : Seo::createSeo();

		}else {

			$route_name = Route::currentRouteName();
			$seo = Seo::getSEO($route_name);
		}

		$view->with('seo', $seo);
	}
}
