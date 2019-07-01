<p class="checkout__text checkout__text-p">
    Puedes utilizar una de las tarjetas de crédito que anteriormente habías utilizado o una nueva:
</p>

@include('client.checkout.partials.payment.user-cards')

<div class="checkout__checkbox-container-card">
    <label for="new_card" class="input__checkbox checkout__checkbox-label checkout__checkbox-label-black {{  empty($cards) ? "hidden" : "" }}">
        {!! Form::checkbox('other_card', true, null, [
            'class'	    => 'input__checkbox checkout__input-checkbox',
            'form'      => 'checkout_form',
            'v-model'   => "new_card",
            'id' 	    => 'new_card',
            ( empty($cards) ? "checked" : "" )
            ]) !!}
            Nueva tarjeta de crédito
    </label>
</div>

<div v-if="new_card === true">
    @include('client.checkout.partials.payment.new_card')
</div>
