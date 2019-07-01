@extends('layouts.test-client', ['body_id'	=> 	'checkout-vue'])

@section('content')
	@include('client.general.header')
	@include('client.shopping-cart.partials.shopping-cart')
	@include('client.general._footer')
@endsection

@section('vue_templates')
@endsection
