<div class="checkout__data-container">

    <div class="checkout__title-container">
        <h3 class="checkout__title">método de pago</h3>
        <div class="checkout__title checkout__paypal-text ">
            Si tu tarjeta fue expedida fuera de México, te recomendamos pagar con Paypal.
            <br><br>
            <i style="font-style: italic">If your credit card was issued outside Mexico, we would recomend to pay with Paypal.</i>
        </div>
        <div class="checkout__card-img-container">
            <h3 class="checkout__title checkout__card-img-ttl">Tarjetas de Credito</h3>
            <div class="flex flex-cont--sb">
                <span><img class="checkout__card-img" src="{{asset('images/ccard-visa.png')}}" alt="" @click="payment_method = 'tarjeta'"></span>
                <span><img class="checkout__card-img" src="{{asset('images/ccard-mastercard.png')}}" alt="" @click="payment_method = 'tarjeta'"></span>
                <span><img class="checkout__card-img" src="{{asset('images/ccard-amex.png')}}" alt="" @click="payment_method = 'tarjeta'"></span>
            </div>
            <h3 class="checkout__title checkout__card-img-ttl">Pago en efectivo</h3>
            <span><img class="checkout__card-img spei" src="{{asset('images/spei.png')}}" alt="" @click="payment_method = 'spei'"></span>
            <h3 class="checkout__title checkout__card-img-ttl">Pago con paypal</h3>
            <span><img class="checkout__card-img spei" src="{{asset('images/paypal.png')}}" alt="" @click="payment_method = 'paypal'"></span>
        </div>
    </div>

    <div class="checkout__link-as-button-container">
        <span class="input__submit checkout__link-as-button--sm"
            v-bind:class="{selected: payment_method === 'tarjeta'}"
            @click="payment_method = 'tarjeta'"
        >tarjeta de crédito</span>
        <span class="input__submit checkout__link-as-button--lg"
            v-bind:class="{selected: payment_method === 'spei'}"
            @click="payment_method = 'spei'"
        >transferencia por spei</span>
        <span class="input__submit checkout__link-as-button--xs"
            v-bind:class="{selected: payment_method === 'paypal'}"
            @click="payment_method = 'paypal'"
        >paypal</span>
    </div>

    <input type="hidden" name="payment_method" v-model="payment_method" form="checkout_form">

    <div v-if="payment_method === 'tarjeta'"> {{-- pago con card --}}
        @include('client.checkout.partials.payment.card')
    </div>

    <div v-if="payment_method === 'spei'"> {{-- pago con spei --}}
        @include('client.checkout.partials.payment.spei')
    </div>

    <div class="divisor"></div>

</div>
