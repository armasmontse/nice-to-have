@extends('layouts.client', ['body_id'	=> 	'checkout-vue'])

@section('title')
    | Carrito
@endsection

@section('content')
    <div class="grid__row">
        @include('client.general.page-title', ['title' => 'carrito'])

        <div class="grid__container">
            <div class="grid__col-1-1">
                @include('client.shopping-cart.partials.menu')

                @if ($bag->event)
                    @include('client.shopping-cart.variations.event-info',[
                        'event' => $bag->event,
                    ])
                @endif

            </div>
        </div>

        <div class="grid__container" v-if="store.bags[store.current_bag].total < 1">
            <div class="grid__col-1-1 text-center">
                <div class="shopping-cart__item-total-container" >
                    <p class="shopping-cart__text"  >
                        El carrito esta vacio
                    </p>
                </div>
            </div>
        </div>
        <div class="grid__container" v-else>
            <div class="grid__col-1-2">


                <div  v-for="product in currentBagProductsWithSelectedSkusQuantitiesAndPrices">
                    <single-product
                        :product="product"
                        :current-language="store.current_language"
                        :products-in-wishlist="store.products_in_wishlist"
                        :bag-keys="store.bag_keys"
                        :printable-bag-index-by-printable-bag-slug="printableBagIndexByPrintableBagSlug"
                        :skus-by-printable-bag="skusByPrintableBag"
                        :current-bag="store.current_bag"
                    ></single-product>
                </div>
            </div>

            <div class="grid__col-1-2 shopping-cart__col">
                <shopping-bag-with-prices
                    :current-bag="store.current_bag"
                    :bag="currentBagProductsWithSelectedSkusQuantitiesAndPrices"
                    :exchange-rate="store.exchange_rate"
                    :iva="store.iva"
                    :is-shopping-bag="true"
                ></shopping-bag-with-prices>
            </div>
        </div>
    </div>
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
                :client-url="product.client_url"
                :is-single="false"
            ></single-product-info>
        </div>
    </script>

    <script type="x/templates"  id="shopping-bag-with-prices-template">
        <div class="grid__box shopping-cart__box">
            <div class="shopping-cart__item-total-container" >
                @include('client.shopping-cart.partials.item-total')
            </div>
            @include('client.shopping-cart.partials.bill')

            <div class="shopping-cart__button-container">
                <a href="{{route("client::bag.checkout.register",$bag_key)}}" class = 'input__submit'>Ir a pagar</a>
                {{-- {!! Form::submit('realizar pago', ['class' => 'input__submit']) !!} --}}
            </div>

            <div class="shopping-cart__link-container">
                <a href="{{route("client::shop.index")}}" class="shopping-cart__link">Continuar comprando</a>
            </div>
        </div>
    </script>
    @include('client.single.vue.single-product-info-template--shopping-carts-variation')
@endsection

@section('vue_store')
<script>
    mainVueStore.current_bag            = {!! json_encode($bag_slug)!!}
    mainVueStore.current_bag_products   = {!! json_encode($products)!!}
</script>
@endsection
