{{-- siguiente pantallas --}}
	{{-- Types --}}
<div v-if="selected_shop_submenu === 'types'" class="menuResponsive__screen" transition="slideRight">
	<div v-if="selected_type_id === -1" transition="fade">
		@include('client.menus.menu-mobile-header', ['name'	=> 	'Tipo de Evento', 'back_button'	=> 	true, 'reset_filters'	=> 	false])
		<h3 v-for="type in typesById"
			class="shop__ttl shop__ttl--filter"
		>
			<a :href="type.client_url" >@{{type.label}}</a>
		</h3>
	</div>
</div>

	{{-- Categories --}}
<div v-if="selected_shop_submenu === 'categories'" class="menuResponsive__screen" transition="slideRight">
	<div v-if="selected_category_id === -1" transition="fade">
		@include('client.menus.menu-mobile-header', ['name'	=> 	'Categorías', 'back_button'	=> 	true, 'reset_filters'	=> 	false])
		<h3 v-for="category in categoriesById"
			class="shop__ttl shop__ttl--filter"
		>
			<a :href="category.client_url">@{{category.label}}</a>
		</h3>
	</div>
</div>
