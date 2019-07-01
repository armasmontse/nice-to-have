@extends('layouts.client', ['body_id' => 'user-vue'])

@section('title')
    | Favoritos
@endsection

@section('content')
<div class="grid__container">
	<div class="grid__container" v-if="store.products_in_wishlist.length === 0">
		<div class="grid__col-1-1 text-center">
		    <div class="shopping-cart__item-total-container" >
		        <p class="shopping-cart__text"  >
		            Tu lista de favoritos está vacía
		        </p>
		    </div>
		</div>
	</div>
	<div class="grid__col-1-2"  v-for="product in productsInWishlist">
		<single-product
			:products-in-wishlist="store.products_in_wishlist"
			:product="product"
			:bag-keys="store.bag_keys"
			:printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
			:skus-by-printable-bag="skusByPrintableBag"
			bag-slug="personal"
		></single-product>
	</div>
	<div class="grid__col-1-1">
		{{-- Botón ScrollUp --}}
		@include('client.general.scroll-up-icon')
	</div>
</div>
@endsection

@section('vue_templates')
	<script type="x/templates" id="single-product-template">
		<div>
	        <single-product-info
				:in-wishlist="in_wishlist"
				:is-wishlist="true"
	        		:variants="variants"
				:title="title"
				:description="mainDescription"
				:id="product.id"
				:is-single="true"{{-- Kacky, pero es para seleccionar la opcion correcta en el ready() --}}
				:bag-keys="bagKeys"
                		:client-url="product.client_url"
				:printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
				:skus-by-printable-bag="skusByPrintableBag"
				:bag-slug="bagSlug"
	        	>
	    	</single-product-info>
		</div>
	</script>
    @include('client.single.vue.single-product-info-template--shopping-carts-variation')
@endsection

@section('vue_store')
<script>
	mainVueStore.user_products = {!! $products !!};
</script>
@endsection
