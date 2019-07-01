<script type="x/templates" id="menu-mobile-template">
	<div class="menuResponsive__fixing-container" :class="{'open': isOpen}"  v-touch:tap="closeOnTap">
		<div class="menuResponsive__outside-click-area" v-if="isOpen" :transition="openingTransition || 'slide'" v-touch:tap="closeOnTap">
			<div class="menuResponsive__container menuResponsive__container_JS"
				v-if="isOpen"
				:transition="openingTransition || 'slide'"
				:class="{
					'filters': menu === 'filters',
					'shop': menu === 'shop',
					'main': menu === 'main'
				}"
				@click.stop
			>
				<div class="menuResponsive">
					<div v-if="menu === 'main'">
						<section class="menuResponsive__section">
							<div class="menuResponsive__header">
								<div class="menuResponsive__header-logo menuResponsive__container-padding">
									{!! file_get_contents('images/logo-movil.svg') !!}
								</div>
							</div>
						</section>
						<div class="menuResponsive__divisor-container"><div class="divisor"></div></div>

						@include('client.menus.menu-mobile-main', ['show_reset'	=> 	false])
					</div>

					<div v-if="menu === 'shop'">
						@include('client.menus.menu-mobile-filters-main', ['show_reset'	=> 	false, 'show_price_range' => false])
						@include('client.menus.menu-mobile-filters--links', ['show_reset' => false])
					</div>

					<div v-if="menu === 'filters'">
						@include('client.menus.menu-mobile-filters-main', ['show_reset'	=> 	true, 'show_price_range' => true])
						@include('client.menus.menu-mobile-filters')
					</div>
				</div>
			</div>
		</div>
	</div>
</script>
