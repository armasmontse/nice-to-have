@extends('layouts.test-client')

@section('content')
<div id="shop-vue">
	<h1 style="font-size: 50px">Shop Product</h1>
	<div class="grid__row">
		<div class="grid__container">
			<div class="grid__col-1-3">
				<shop-product></shop-product>
			</div>
			<div class="grid__col-1-3">
				<shop-product></shop-product>
			</div>
			<div class="grid__col-1-3">
				<shop-product></shop-product>	
			</div>
			<div class="grid__col-1-3">
				<shop-product></shop-product>
			</div>
			<div class="grid__col-1-3">
				<shop-product></shop-product>
			</div>
			<div class="grid__col-1-3">
				<shop-product></shop-product>	
			</div>
		</div>
	</div>
</div>
@endsection

@section('vue_templates')
	@include('client.shop.shop-product')
@endsection
