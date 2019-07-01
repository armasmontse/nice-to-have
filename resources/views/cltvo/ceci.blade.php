{{-- Vista prueba del checkout --}}

@include('client.general.page-title', ['title' => 'carrito'])

<div class="grid__row">
    <div class="grid__container">
        <div class="grid__col-1-1">
            @include('client.shopping-cart.partials.menu')
            @if (true)
                @include('client.shopping-cart.variations.user-info')
            @endif
        </div>
    </div>

    <div class="grid__container">
        <div class="grid__col-1-2 checkout__col-1-2">
            <div class="grid__box checkout__box checkout__box-right"> {{-- de aquí hacia abajo es el pedazo de vista --}}
                {{-- <div class="checkout__data-container">
                    <div class="checkout__title-container">
                        <span class="checkout__title">envia un mensaje junto con tu regalo:</span>
                    </div>

                    <div class="checkout__input-container">
                        {!! Form::textarea('inputname', null, [
                            'class' => 'input__textarea checkout__input',
                            'placeholder' => 'Mensaje',
                            'required' => 'required'])
                        !!}
                        </div>
                    <div class="divisor"></div>
                </div>

                @include('client.checkout.partials.cart-info')--}}

                @include('client.checkout.partials.shipping-address')

                <div class="checkout__data-container">
                    <div class="checkout__title-container">
                        <span class="checkout__title">método de pago:</span>
                    </div>

                    <div class="checkout__link-as-button-container">
                        <a class="input__submit checkout__link-as-button--sm" >tarjeta de crédito</a>
                        <a class="input__submit checkout__link-as-button--lg" >transferencia por spei</a>
                    </div>

                    @if (false)
                        @include('client.checkout.partials.payment')

                        <div class="checkout__checkbox-container-card">
                            <label for="new_card" class="input__checkbox checkout__checkbox-label checkout__checkbox-label-black"> {{-- {{  empty($cards) ? "hidden" : "" }} --}}
                                {!! Form::checkbox('other_card', true, null, [
                                    'class'	    => 'input__checkbox',
                                    'form'      => 'checkout_form',
                                    'v-model'   => "new_card",
                                    'id' 	    => 'new_card',
                                    // ( empty($cards) ? "checked" : "" )
                                    ]) !!}
                                    Nueva tarjeta de crédito
                            </label>
                        </div>
                        @include('client.checkout.partials.payment-card')
                    @endif

                    @include('client.checkout.partials.payment-spei')

                    <div class="divisor"></div>
                </div>
            </div>
        </div>
        <div class="grid__col-1-2 checkout__col-1-2">
            <div class="grid__box checkout__box checkout__box-left">
                <div class="checkout__title-container">
                    @include('client.checkout.partials.item-total')
                </div>

                @include('client.checkout.partials.cart-items')

                <div class="checkout__title-container--xl">
                    <span class="checkout__title">resumen de compra</span>
                </div>

                <div class="checkout__bill-container">
                    @include('client.shopping-cart.partials.bill')
                </div>

                @include('client.checkout.partials.checkbox-option')

                <div class="checkout__link-container">
                    <span class="input__submit checkout__link-button checkout__link--lg pseudo-submit_JS"
                    v-bind:disabled="!store.creditCardDetails.details_are_complete || !store.shippingAddress.address_is_complete || !store.termsAccepted"
                    v-on:click="placeOrderPost"
                    v-if="!waiting_for_conekta"
                    >
                        realizar orden de compra
                    </span>

                    @if (true) {{-- pago spei --}}
                        <span class="input__submit checkout__link-button">
                            generar id de compra
                        </span>
                    @endif

                    <a href="#" class="checkout__link">
                        Regresar al carrito
                    </a>

                    <span v-else>
                        {{-- @include('client.general.loading-icon') --}}
                    </span>
                </div>
            </div>
        </div>
    </div>
</div>
