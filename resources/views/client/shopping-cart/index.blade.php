@extends('layouts.client', ['body_id' => 'main-vue'])

@section('title')
	| Carritos
@endsection

@section('content')

<div class="grid__row shopping-cart">
	@include('client.general.page-title', ['title' => 'carrito'])

	<div class="grid__container">
		<div class="checkout__menu-mobile">
			<div class="grid__col-1-1">
				<div class="shopping-cart__text-container--info-section">
					<h2 class="shopping-cart__text shopping-cart__text--ttl--sm"
						v-bind:class='{"selected": shown_cart === "personal"}'
						@click="showCart('personal')"
					>Regalos para mi o para alguien más:</h2>
					<h2 class="shopping-cart__text shopping-cart__text--ttl--sm"
						v-bind:class='{"selected": shown_cart === "mesa"}'
						@click="showCart('mesa')"
					>Mesa de regalos:</h2>
				</div>
				<div class="divisor"></div>
			</div>
		</div>
		<div class="grid__container">
			<div class="grid__col-1-2 checkout__col-1-2"
				v-bind:class='{"hide--sm": shown_cart !== "personal"}'>
				<div class="checkout__box checkout__box-right">
					<div v-if="personalBagProductsWithSelectedSkusQuantitiesAndPrices.length > 0">
						<div class="grid__box shopping-cart__box--info-section">
							<div class="shopping-cart__text-container--info-section shopping-cart__text-container--info-section--personal">
								<h2 class="shopping-cart__text shopping-cart__text--ttl">
									Regalos para mi o para alguien más:
								</h2>
							</div>
							<shopping-bag-with-prices
							:bag="personalBagProductsWithSelectedSkusQuantitiesAndPrices"
							:exchange-rate="store.exchange_rate"
							:iva="store.iva"
							:is-shopping-bag="true"
							:bag-key="store.bag_keys.personal"
							></shopping-bag-with-prices>
						</div>

						<div class="divisor shopping-cart__divisor"></div>

						<div class="grid__box">
							<div  v-for="product in personalBagProductsWithSelectedSkusQuantitiesAndPrices">
								<single-product
								:product="product"
								:current-language="store.current_language"
								:products-in-wishlist="store.products_in_wishlist"
								:bag-keys="store.bag_keys"
								:printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
								:skus-by-printable-bag="skusByPrintableBag"
								bag-slug="personal"
								:is-shopping-bag="true"
								></single-product>
							</div>
						</div>
					</div>
					<div v-else class="grid__box shopping-cart__box--info-section">
						<div class="shopping-cart__text-container--info-section shopping-cart__text-container--info-section--personal">
							<h2 class="shopping-cart__text shopping-cart__text--ttl">Regalos para mi o para alguien más:</h2>
						</div>
						<div class="shopping-cart__button-container">
							<a href="{{route('client::shop.index')}}" class="input__submit">Ir a tienda</a>
						</div>
						<div class="shopping-cart__text shopping-cart__text--ttn">
							{!! $shopping_carts_personal_shopping_cart_empty_copy !!}
						</div>
					</div>
				</div>
			</div>

			<div class="grid__col-1-2 checkout__col-1-2"
				v-bind:class='{"hide--sm": shown_cart !== "mesa"}'>
				<div class="checkout__box checkout__box-left">
					<div v-if="mesaBagProductsWithSelectedSkusQuantitiesAndPrices.length > 0">
						<div class="grid__box shopping-cart__box--info-section">
							<div class="shopping-cart__text-container--info-section shopping-cart__text-container--info-section--mesa">
								<h2 class="shopping-cart__text shopping-cart__text--ttl ">Mesa de regalos:</h2>
								<div class="shopping-cart__event-info-container">
									<div class="shopping-cart__event-info">
										<p class="shop__ttl--serif--sm text-center" v-text="store.current_event.name"></p>
										<p class="shop__ttl--serif--sm text-center mb0">
											No: <span class="ttu" v-text="store.current_event.key"></span>
										</p>
									</div>
								</div>
							</div>
							<shopping-bag-with-prices
							:bag="mesaBagProductsWithSelectedSkusQuantitiesAndPrices"
							:shop-url="store.current_event.shop_url"
							:exchange-rate="store.exchange_rate"
							:iva="store.iva"
							bag-slug="agregar-a-mesa-de-regalos"
							:is-shopping-bag="true"
							:bag-key="store.bag_keys['agregar-a-mesa-de-regalos']"
							></shopping-bag-with-prices>
						</div>
						<div class="divisor shopping-cart__divisor"></div>

						<div class="grid__box">
							<div  v-for="product in mesaBagProductsWithSelectedSkusQuantitiesAndPrices">
								<single-product
								:is-event-shop="true"
								:product="product"
								:current-language="store.current_language"
								:products-in-wishlist="store.products_in_wishlist"
								:bag-keys="store.bag_keys"
								:printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
								:skus-by-printable-bag="skusByPrintableBag"
								bag-slug="agregar-a-mesa-de-regalos"
								:is-shopping-bag="true"
								></single-product>
							</div>
						</div>
					</div>
					<div v-else class="grid__box shopping-cart__box--info-section shopping-cart__text-container--info-section--mesa">
						<h2 class="shopping-cart__text--pad shopping-cart__text shopping-cart__text--ttl">Mesa de regalos:</h2>
						<div class="shopping-cart__button-container">
							<a href="{{route("client::events.search")}}" class="input__submit">Buscar evento</a>
						</div>
						<div class="shopping-cart__text shopping-cart__text--ttn">
							{!! $shopping_carts_event_shopping_cart_empty_copy !!}
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="grid__col-1-1">
			{{-- Botón ScrollUp --}}
			@include('client.general.scroll-up-icon')
		</div>
	</div>

</div>
@endsection

@section('vue_store')
<script>
	mainVueStore.current_bags = {!!$current_bags!!}
</script>
@endsection

@section('vue_templates')
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

<script type="x/templates" id="shopping-bag-with-prices-template">
	<div class="grid__box shopping-cart__box">

		<div class="shopping-cart__item-total-container" >
			@include('client.shopping-cart.partials.item-total')
		</div>

		@include('client.shopping-cart.partials.bill')

		<div class="shopping-cart__link-container shopping-cart__link-container--compra">
			<a href="{{route("client::bag.checkout.register", '&#123;&#123;bagKey&#125;&#125;')}}" class="input__submit single__submit">Proceder a compra</a>
		</div>
		<div class="shopping-cart__link-container">
			<a v-if="bagSlug === 'agregar-a-mesa-de-regalos'" :href="shopUrl" class="shopping-cart__link">Continuar comprando en mesa de regalos</a>
			<a v-else href="{{route("client::shop.index")}}" class="shopping-cart__link">Continuar comprando</a>
		</div>
	</div>
</script>
@include('client.single.vue.single-product-info-template--shopping-carts-variation', [
	'special_col_left'	=> 	'shopping-cart__col-1-2 shopping-cart__col-1-2--left',
	'special_col_right'	=> 	'shopping-cart__col-1-2 shopping-cart__col-1-2--right'
])
@endsection
