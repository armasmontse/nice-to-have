@extends('layouts.test-client', ['body_id'	=> 	'shop-vue'])

@section('content')
	@include('client.general.header')
	@include('client.shopping-cart.index')
	@include('client.general._footer')
@endsection

@section('vue_templates')
@endsection
