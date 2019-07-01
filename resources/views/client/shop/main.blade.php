@extends('layouts.client',  ['body_id'	=> 	'shop-vue'])

@section('title')
	| Categorías
@endsection

@section('content')

	@include('client.shop.partials.menu-shop-filters'){{-- Filtros en su versión mobil  --}}

	<div class="shop">
		<div class="grid__row">
			<div class="grid__container p0">
				<div class="grid__sidebar shop__sidebar shop__sidebar_JS">
					@include('client.shop.partials.sidebar(assembled)', ['menu_mobile_name'	=> 	'filters'])
				</div>
				<div class="grid__main shop__main">
					@include('client.shop.variations.filters')
				</div>
			</div>
		</div>
	</div>

@endsection

@section('vue_templates')
	@include('client.shop.vue.shop-product-template')
@endsection

@section('vue_store')
	@include('client.shop.partials.get-requests')
<script>
	mainVueStore.is_event_shop = {!! json_encode($is_event_shop) !!};
</script>
@endsection
