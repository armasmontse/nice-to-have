{{-- Paso 1 - Info --}}
@include('client.home.partials.steps', [
	'container__class'	=> 	'home__container--steps--pt-smaller home__container--steps--pb-smaller',
	'title' 	=>	$section->components[0]->title,
	'number' 	=> 	$section->components[0]->subtitle,
	'content'	=> 	$section->components[0]->content
])

{{-- Paso 1 - 2 images --}}
@include('client.home.partials.two-images', [
	'img_1' => 	isset($section->components[0]->gallery_images[0]->url) ? $section->components[0]->gallery_images[0]->url : '',
	'img_2'	=> 	isset($section->components[0]->gallery_images[1]->url) ? $section->components[0]->gallery_images[1]->url : ''
])

{{-- Paso 2 - Info --}}
@include('client.home.partials.steps', [
	'title' 	=>	$section->components[1]->title,
	'number' 	=> 	$section->components[1]->subtitle,
	'content'	=> 	$section->components[1]->content
])

{{-- Paso 2 - 3 imagenes --}}
@include('client.home.partials.three-images', [
	'img_1' => 	isset($section->components[1]->gallery_images[0]->url) ? $section->components[1]->gallery_images[0]->url : '',
	'img_2'	=> 	isset($section->components[1]->gallery_images[1]->url) ? $section->components[1]->gallery_images[1]->url : '',
	'img_3'	=> 	isset($section->components[1]->gallery_images[2]->url) ? $section->components[1]->gallery_images[2]->url : ''
])

{{-- Paso 3 - Info --}}
@include('client.home.partials.steps', [
	'container__class'	=> 	'home__container--steps--pb-smaller',
	'title' 	=>	$section->components[2]->title,
	'number' 	=> 	$section->components[2]->subtitle,
	'content'	=> 	$section->components[2]->content
])

{{--  CTA --}}
<div class="grid__container home__container--cta-buttons-main-container pt0">
	<div class="grid__col-1-1">
		<div class="home__cta-buttons-container home__cta-buttons-container--small">
			<a href="{{route("client::event.register")}}" class="input__submit">Crea tu evento</a>
			<a href="{{route('client::shop.index')}}" class="input__submit">Ir a la tienda</a>
		</div>
	</div>
</div>
