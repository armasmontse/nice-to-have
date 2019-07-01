@extends('layouts.client', ['body_id'	=> 	'shop-vue', 'errors' => '[]', 'link_parts'	=> 	''])

@section('content')
<div class="debug">
	@include('client.general.header')
	@include('client.single.show')
	@include('client.general._footer')
</div>
@endsection

@section('vue_templates')
	@include('client.shop.vue.shop-product-template')
@endsection
