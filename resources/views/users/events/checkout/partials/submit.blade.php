<div  v-if="step === 2">
    <div class="checkout__link-container">
      <span class="input__submit checkout__link-button" @click.stop.prevent="goToStep3">
             Siguiente
         </span>

        <a href="{{ route('client::bags.index') }}" class="checkout__link checkout__link-terms">
            Regresar al carrito
        </a>
    </div>
</div>

<div v-if="step === 3">
    <div class="checkout__checkbox-container">
        <span @click.self="scroll2PaymentMethod">
            <label for="accept_terms" class="input__checkbox-label checkout__checkbox-label">
                {!! Form::checkbox('accept_terms', true, null, [
                    'class'     => 'input__checkbox',
                    'required'  => 'required',
                    'form'      => 'checkout_form',
                    'id'        => 'accept_terms',
                    'v-model'   => 'store.termsAccepted'
                ]) !!}
                Acepto los <a class="checkout__link checkout__link-grey" href="{{route("client::pages.show","terminos-y-condiciones") }}" target="_blank" >Términos y condiciones</a>
            </label>
        </span>
    </div>


    <div class="checkout__link-container">
        <span class="input__submit checkout__link-button checkout__link--lg pseudo-submit_JS"
        v-bind:disabled="!store.creditCardDetails.details_are_complete || !shipping_info_is_complete || !store.termsAccepted"
        v-on:click.stop="placeOrderPost"
        v-if="!waiting_for_conekta"
        v-text="{
                tarjeta: 'realizar orden de compra',
                spei: 'generar CLABE de compra',
                paypal: 'pagar con paypal'
            }[payment_method]  || 'realizar pago'"
        >
            Realizar Pago
        </span>
        <span v-else>
            @include('client.general.loading-icon')
        </span>

        <a href="{{ route('client::bags.index') }}" class="checkout__link checkout__link-terms">
            Regresar al carrito
        </a>
    </div>
</div>
