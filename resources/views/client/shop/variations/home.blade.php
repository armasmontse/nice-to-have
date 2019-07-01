<section class="shop__home">
{{-- 1/2 lg-sm --}}
	<div class="grid__container shop__container--h-500">{{-- cada línea lleva su container para mantener la estrctura de los nth-childs --}}
		@include('client.shop.partials.filter-header',[
			"image_url" 	=> asset('images/shop/shop_1.jpg'),
			"image_label"	=> "muebles & interiorismo",
			"link" 			=> route('client::shop.filters.category', 'muebles-interiorismo'),
			"title" 		=> "Espacio",
			"subtitle" 		=> "Acogedor",
			"description"	=> "Se refiere a una colección de objetos entre los que pueden definirse relaciones de adyacencia y cercanía.",
		])
	</div>

	{{-- 1/2 left --}}
	<div class="grid__container shop__container--h-450">
		<div class="shop__flex-subcontainer">
			<div class="shop__col--static shop__col--h-450  shop__col shop__col--xs grid__pad-for-2" >
				@include('client.shop.partials.grid-info-box',[
					"link" 			=> route('client::shop.filters.category', 'diseño-y-decoracion'),
					"title" 		=> "Detalles",
					"subtitle" 		=> "Ambientación",
					"description"	=> "Contribuyen a formar y completar una cosa o situación haciendo muy especial algo que en principio era básico.",
				])
			</div>
			<div class="shop__col--flex shop__col--h-450  shop__col shop__col--xs grid__pad-for-2">
				<a href="{{route('client::shop.filters.category', 'estilo-de-vida')}}" class="shop__bg-img" style="background-image: url({{asset('images/shop/shop_6.jpg')}})">
					<div class="shop__ttl--featured-container">
						<h3 class="shop__ttl shop__ttl--featured">diseño y decoración</h3>
					</div>
				</a>
			</div>
		</div>
	</div>

	{{-- 1/2 right --}}
	<div class="grid__container shop__container--h-450">
		<div class="shop__flex-subcontainer">
			<div class="shop__col--flex shop__col--h-450  shop__col shop__col--xs grid__pad-for-2">
				<a href="{{route('client::shop.filters.category', 'mesa-cocina')}}" class="shop__bg-img" style="background-image: url({{asset('images/shop/shop_3.jpg')}})">
					<div class="shop__ttl--featured-container">
						<h3 class="shop__ttl shop__ttl--featured">mesa & cocina</h3>
					</div>
				</a>
			</div>
			<div class="shop__col--static shop__col--h-450  shop__col shop__col--xs grid__pad-for-2">
				@include('client.shop.partials.grid-info-box',[
					"link" 			=> route('client::shop.filters.category', 'mesa-cocina'),
					"title" 		=> "Rituales",
					"subtitle" 		=> "Tradición",
					"description"	=> "De valor simbólico, basado en las creencias, tradiciones y herencias de cada persona.",
				])
			</div>
		</div>
	</div>

	{{-- 1/2 left --}}
	<div class="grid__container shop__container--h-450">
		<div class="shop__flex-subcontainer">
			<div class="shop__col--static shop__col--h-450  shop__col shop__col--xs grid__pad-for-2" >
				@include('client.shop.partials.grid-info-box',[
					"link" 			=> route('client::shop.filters.category', 'estilo-de-vida'),
					"title" 		=> "Placeres",
					"subtitle" 		=> "Goce",
					"description"	=> "En su forma natural se manifiestan cuando conscientemente se satisface plenamente alguna necesidad.",
				])
			</div>
			<div class="shop__col--flex shop__col--h-450  shop__col shop__col--xs grid__pad-for-2">
				<a href="{{route('client::shop.filters.category', 'estilo-de-vida')}}" class="shop__bg-img" style="background-image: url({{asset('images/shop/shop_4.jpg')}})">
					<div class="shop__ttl--featured-container">
						<h3 class="shop__ttl shop__ttl--featured">estilo de vida</h3>
					</div>
				</a>
			</div>
		</div>
	</div>

	{{-- 1/2 der --}}
	<div class="grid__container shop__container--h-450">
		<div class="shop__flex-subcontainer">
			<div class="shop__col--flex shop__col--h-450  shop__col shop__col--xs grid__pad-for-2">
				<a href="{{route('client::shop.filters.category', 'ella-el')}}" class="shop__bg-img" style="background-image: url({{asset('images/shop/shop_5.jpg')}})">
					<div class="shop__ttl--featured-container">
						<h3 class="shop__ttl shop__ttl--featured">ella & él</h3>
					</div>
				</a>
			</div>
			<div class="shop__col--static shop__col--h-450  shop__col shop__col--xs grid__pad-for-2">
				@include('client.shop.partials.grid-info-box',[
					"link" 			=> route('client::shop.filters.category', 'ella-el'),
					"title" 		=> "Estilo",
					"subtitle" 		=> "Personalidad",
					"description"	=> "Conjunto de rasgos peculiares que caracterizan a una persona dándole personalidad propia y reconocible.",
				])
			</div>
		</div>
	</div>

	{{-- 1/2 left --}}
	<div class="grid__container shop__container--h-450">
		<div class="shop__flex-subcontainer">
			{{-- <div class="shop__col--static  shop__col--h-450  shop__col shop__col--xs grid__pad-for-2" >
				@include('client.shop.partials.grid-info-box',[
					"link" 			=> route('client::shop.filters.category', 'plantas-y-jardineria'),
					"title" 		=> "",
					"subtitle" 		=> "",
					"description"	=> "",
				])
			</div> --}}
			<div class="shop__col--flex shop__col--h-450  shop__col shop__col--xs grid__pad-for-2">
				<a href="{{route('client::shop.filters.category', 'diseño-decoracion')}}" class="shop__bg-img" style="background-image: url({{asset('images/shop/shop_2.jpg')}})">
					<div class="shop__ttl--featured-container">
						<h3 class="shop__ttl shop__ttl--featured">plantas & jardinería</h3>
					</div>
				</a>
			</div>
		</div>
	</div>

</section>
