<div class="menuResponsive__header">
	<h3 class="menuResponsive__header-ttl">
		{{$name}}@{{sub_something_name !== '' ? ': ' + sub_something_name : ''}}
		<span @click="selected_category_id = -1" class="menuResponsive__back">
			{!! file_get_contents('images/menu-arrow-left.svg') !!}
		</span>
	</h3>
	<div class="menuResponsive__button-container">
		<button
			@click.self="unselectAllSubs('category', 'categories', selected_category_id)"
			class="menuResponsive__button"
		>Borrar</button>
	</div>
	<div class="divisor menuResponsive__divisor"></div>
</div>



