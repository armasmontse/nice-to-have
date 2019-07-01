<div class="checkout__data-container">

    <div class="checkout__title-container">
        <span class="checkout__title">método de pago</span>
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
