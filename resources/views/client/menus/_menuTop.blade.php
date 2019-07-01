<style media="screen">
	.menuTop__searchbar .coming_soon { display: none; }
	.menuTop__searchbar:hover .item { display: none; }
	.menuTop__searchbar:hover .coming_soon { display: inline; }
</style>

<nav id="menuTop" class="menuTop">
	<div class="grid__row">
		<div class="grid__container menuTop__container">
			<div class="menuTop__col menuTop__col--left menuTop__col--hamburger" @click.stop="toggleMenu('main')">
				<span
					v-if="store.menus.filters.isOpen === false && store.menus.shop.isOpen === false">
					{{-- {!! file_get_contents('images/logo-hamburger.svg') !!} --}}
					&#9776;
				</span>
				<span v-else>{!! file_get_contents('images/logo-close.svg') !!}</span>
			</div>

			<div class="menuTop__col menuTop__col--left menuTop__col--search"></div>

			<div id="menuTop__logo" class="menuTop__col menuTop__col--logo">
				<a href="{{ route("client::pages.index")  }}">
					{!! file_get_contents('images/logo-menuTop.svg') !!}
				</a>
			</div>
			<div class="menuTop__menuUser">
				<div class="menuTop__link menuTop__link-account">
					<user-account-menu :is-open="store.menus.userAccount.isOpen"></user-account-menu>
				</div>
				<div class="menuTop__link menuTop__link--bag">
					<a href="{{route("client::bags.index")}}">
						<span class="menuTop__bag-counter">@{{totalItemsInBags}}</span> Carrito
					</a>
					{{-- shopping bag menu se sustityó por lo de arriba, no hubo cambios en el JS --}}
				</div>
			</div>
		</div>
	</div>
</nav>
