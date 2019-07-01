@extends('layouts.test-client', ['body_id' => 'main-vue'])

@section('content')
<style>
	body {
		height: 300vh;
	}
</style>
	@include('client.general.header')
	@include('client.general._footer')
@endsection

@section('vue_templates')
	@include('client.general.vue.shoppingBagMenu')
	@include('client.general.vue.userAccountMenu')
@endsection
