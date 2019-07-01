{{-- primera pantalla --}}
<div class="menuResponsive__main-section" v-if="selected_shop_submenu === ''" transition="fade">
	<section class="">
		<div class="menuResponsive__container-padding">
			<p class="menuResponsive__link" @click="selected_shop_submenu = 'user-account'">
				Mi Cuenta
				{!! file_get_contents('images/menu-arrow-right.svg') !!}
			</p>
			<a class="menuResponsive__link" href="{{route("client::bags.index")}}" {{-- @click="selected_shop_submenu = 'shopping-bags'" --}}>
				Carrito <span class="menuResponsive__bag-counter">@{{totalItemsInBags}}</span>
				{!! file_get_contents('images/menu-arrow-right.svg') !!}
			</a>
		</div>
	</section>
	<div class="menuResponsive__divisor-container"><div class="divisor"></div></div>

	<section class="menuMain--mobile">
		<div class="menuResponsive__container-padding">
			@include('client.menus._menuMain')
		</div>
	</section>
	<div class=""><div class="divisor"></div></div>

	<section class="">
		<div class="menuResponsive__container-padding">
			@include('client.menus._menuFooter')
			@include('client.menus._menuLegal-FAQ')
		</div>
	</section>
</div>


{{-- Los siguientes tags sólo aparecen cuando se accede a un submenu --}}
{{-- userAccount --}}
<nav class="menuResponsive__nav-container"
		v-if="selected_shop_submenu === 'user-account'""
		transition="slide"
	>
		@include('client.menus.menu-mobile-header', ['name'	=> 	'Mi Cuenta', 'back_button'	=> 	true, 'reset_filters' => false])
	<div class="menuResponsive__container-padding">
		@include('client.menus.userAccountMenu-links')
	</div>
</nav>
{{-- shoppingBag --}}
<nav class="menuResponsive__nav-container"
	v-if="selected_shop_submenu === 'shopping-bags'""
	transition="slide"
>
			@include('client.menus.menu-mobile-header', ['name'	=> 	'Regalos (0)', 'back_button'	=> 	true, 'reset_filters' => false])
	<div class="menuResponsive__container-padding">
		    @include('client.menus.shoppingBagMenu-links')
	</div>
</nav>
