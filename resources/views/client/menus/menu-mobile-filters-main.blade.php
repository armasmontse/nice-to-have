{{-- primera pantalla --}}
<div class="menuResponsive__screen menuResponsive__screen0" transition="fade" v-if="selected_shop_submenu === ''">
	@include('client.menus.menu-mobile-header', ['name'	=> 	'Filtros', 'back_button'	=> 	false, 'reset_filters'	=> 	true])


{{-- Tipos de Evento --}}
	<h3 class="shop__ttl shop__ttl--filter"
		v-if="currentEvent === null"
		@click="selected_shop_submenu = 'types'">
	Tipos de evento
		<div class="menuResponsive__arrow-container">			
			{!! file_get_contents('images/menu-arrow-right.svg') !!}
		</div>
	</h3>
	<div class="menuResponsive__selected-subs-container" v-if="currentEvent === null">
		<div class="menuResponsive__selected-subs">
			@{{selected_subtypes_with_type | printSelected}}
		</div>
	</div>
	
	{{-- Cuando hay un evento especial --}}
	<h3 class="shop__ttl shop__ttl--filter" v-else>
		Evento: @{{currentEvent.name}}
		<div class="menuResponsive__selected-subs-container"></div>{{-- genera el padding bottom --}}
	</h3>



	
{{-- Categorías --}}
	<h3
		@click="selected_shop_submenu = 'categories'"
		class="shop__ttl shop__ttl--filter">
	Categorías
		<div class="menuResponsive__arrow-container">			
			{!! file_get_contents('images/menu-arrow-right.svg') !!}
		</div>
	</h3>
	<div class="menuResponsive__selected-subs-container">
		<div class="menuResponsive__selected-subs">@{{selected_subcategories_with_category | printSelected}}</div>
	</div>
	


{{-- Rango de precios --}}
	@if($show_price_range == true)
		<h3 @click="selected_shop_submenu = 'price-range'"
			class="shop__ttl shop__ttl--filter">
		Rango de Precios
			<div class="menuResponsive__arrow-container">			
				{!! file_get_contents('images/menu-arrow-right.svg') !!}
			</div>
		</h3>

		<div class="menuResponsive__selected-subs-container">
			<div class="menuResponsive__selected-subs">@{{priceRange | printPriceRange}}</div>
		</div>
	@endif
</div>
