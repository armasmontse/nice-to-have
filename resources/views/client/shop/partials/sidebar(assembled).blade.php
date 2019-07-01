@include('client.shop.partials.breadcrumbs')
@if ($cookie_event)	
	@include('client.shop.partials.event-info')
@endif
<div class="shop__section--filters--responsive"><span class="input__submit shop__button" @click.stop="toggleMenu('{{$menu_mobile_name}}')">Categorias y filtros</span></div>

@if(!$is_event_shop)
	@include('client.shop.partials.searchbar') 
@endif

<div class="shop__section--filters">
	@include('client.shop.partials.filters')
</div>
