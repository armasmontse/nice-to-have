@extends('layouts.client', ['body_id'	=> 	'checkout-event-vue'])

@section('title')
    | Carrito del Evento
@endsection

@section('content')
<div class="grid__row userEvent">

	@include('users.events.general.head')

	<div class="grid__container userEvent__columns">

		<div class="grid__col-1-2 checkout__col-1-2">
			<div class="checkout__box checkout__box-right ovf-vis">
				<div  v-for="product in eventBagProductsWithSelectedSkusQuantitiesAndPrices">
					<single-product
						:is-event-shop="false"
						:product="product"
						:current-language="store.current_language"
						:products-in-wishlist="store.products_in_wishlist"
						:bag-keys="store.bag_keys"
						:printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
						:skus-by-printable-bag="skusByPrintableBag"
						bag-slug="retirar-mesa-de-regalos"
						:is-shopping-bag="true"
					></single-product>
				</div>
			</div>
		</div>

		<div class="grid__col-1-2 checkout__col-1-2">
			<div class="checkout__box checkout__box-left">
				<shopping-bag-with-prices-for-event
					:bag="eventBagProductsWithSelectedSkusQuantitiesAndPrices"
					:exchange-rate="store.exchange_rate"
					:iva="store.iva"
					:is-shopping-bag="true"
					:balance="store.balance"
					:minimum="store.minimum"
					:fee-percentage="store.fee_percentage"
					:in-zona-metropolitana="store.address_in_zmvm"
					:bag-totals="store.bag_totals"
					:close-empty-bag="store.close_empty_bag"
				></shopping-bag-with-prices-for-event>
			</div>
		</div>

	</div>

</div>
@include('users.events.profile.modals')
@endsection

@section('vue_templates')
{{-- Single Product --}}
<script type="x/templates" id="single-product-template">
	<div>
		<single-product-info
		:variants="variants"
		:title="title"
		:main-description="description"
		:id="product.id"
		:in-wishlist="in_wishlist"
		:printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
		:skus-by-printable-bag="skusByPrintableBag"
		:bag-keys="bagKeys"
		:quantity="product.quantity"
		:selected-sku="product.selected_sku"
		:current-bag="currentBag"
		:client-url="isEventShop ? product.event_shop_url : product.client_url"
		:is-single="false"
		:bag-slug="bagSlug"
		:is-shopping-bag="true"
		></single-product-info>
	</div>
</script>
{{-- Single Product Info --}}
@include('client.single.vue.single-product-info-template--shopping-carts-variation', [
	'special_col_left'	=> 	'shopping-cart__col-1-2 shopping-cart__col-1-2--left',
	'special_col_right'	=> 	'shopping-cart__col-1-2 shopping-cart__col-1-2--right'
])
{{-- Shopping Bag --}}
<script type="x/templates"  id="shopping-bag-with-prices-for-event-template">
	<div>@include('users.events.cart.summary')</div>
</script>
@endsection

@section('vue_store')
	 <script>
		mainVueStore.personal_event = {!! isset($personal_event) ? json_encode($personal_event) : '{}' !!}
		mainVueStore.current_bag = {!! json_encode($current_bags->first()) !!}
		mainVueStore.bag = {!! json_encode($bag) !!}
	    mainVueStore.address_in_zmvm = {!! json_encode($address_in_zmvm) !!}
		mainVueStore.balance = {!! json_encode($personal_event->current_total) !!}
		mainVueStore.minimum = {!! json_encode($personal_event->current_checkout_min) !!}
      	mainVueStore.bag_totals = {!! json_encode($bag->bag_totals) !!}
		mainVueStore.fee_percentage = {!! json_encode($personal_event->current_fee_percentage) !!}
		mainVueStore.close_empty_bag = {!! json_encode($personal_event->close_empty_bag) !!}
        	mainVueStore.given_skus = {!! json_encode($given_skus) !!}
	 </script>
@endsection
