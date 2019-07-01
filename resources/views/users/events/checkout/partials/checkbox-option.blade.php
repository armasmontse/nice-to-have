<div class="checkout__checkbox-container">
    <label for="accept_terms" class="input__checkbox-label checkout__checkbox-label">
        {!! Form::checkbox('accept_terms', true, null, [
            'class'     => 'input__checkbox',
            'required'  => 'required',
            'form'      => 'checkout_form',
            'id'        => 'accept_terms',
            'v-model'   => 'store.termsAccepted'
        ]) !!}
        Acepto los <a href="#" class="checkout__link checkout__link-grey">Términos y condiciones</a>
    </label>
</div>
