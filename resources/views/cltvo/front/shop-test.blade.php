@extends('layouts.test-client', ['body_id'	=> 	'shop-vue'])

@section('content')
<div class="debug">
	@include('client.general.header')
	@include('client.shop.index')
	@include('client.general._footer')
</div>
@endsection

@section('vue_templates')
	@include('client.shop.shop-product')
@endsection
