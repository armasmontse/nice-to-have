<div class="menuResponsive__header">
	<h3 class="menuResponsive__header-ttl">
		{{$name}}
		@if($back_button == true)
			<span @click="selected_shop_submenu = ''" class="menuResponsive__back">
				{!! file_get_contents('images/menu-arrow-left.svg') !!}
			</span>
		@endif
	</h3>
</div>
@if(isset($show_reset) ? $show_reset == true : true)
<div class="menuResponsive__button-container">
	@if($reset_filters == true)
		<button
		@click.self="unselectAll"
			class="menuResponsive__button"
		>Borrar</button>
	@endif
	@if(isset($reset_range_filters))
		<button
		@click.self="resetPriceRanges"
			class="menuResponsive__button"
		>Borrar</button>
	@endif
</div>
@endif
<div class="divisor menuResponsive__divisor"></div>
