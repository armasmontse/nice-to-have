@extends('layouts.client', ['body_id' => 'shop-vue'])

@section('title')
	| Tienda
@endsection

@section('content')
	@include('client.shop.partials.menu-shop-home')
	<div class="shop">
		<div class="grid__row">
			<div class="grid__container p0">
				{{-- <div class="grid__sidebar  shop__sidebar">
					@include('client.shop.partials.sidebar(assembled)', ['menu_mobile_name'	=> 	'shop'])
				</div> --}}
				<div class="grid__main-full-width shop__main">
					@include('client.shop.variations.home')
				</div>
			</div>
		</div>
	</div>
@endsection

@section('vue_store')
	@include('client.shop.partials.get-requests')
@endsection
