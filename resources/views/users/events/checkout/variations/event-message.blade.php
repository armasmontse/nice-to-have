<div class="checkout__data-container">
    <div class="checkout__title-container">
        <span class="checkout__title">envia un mensaje junto con tu regalo:</span>
    </div>

    <div class="checkout__input-container">
        {!! Form::textarea('message', null, [
            'class'         => 'input__textarea checkout__input',
            'placeholder'   => 'Mensaje',
            //'form'          => 'checkout_form',
            'v-model' => 'friendly_message'
            // 'required' => 'required'
        ])!!}
    </div>
    <div class="checkout__checkbox-container checkout__checkbox-container--card">
        <label for="print_message" class="input__checkbox-label checkout__checkbox-label">
            {!! Form::checkbox('print_message', true, true, [
                'class'     => 'input__checkbox',
                'required'  => 'required',
                'form'      => 'checkout_form',
                'id'        => 'print_message',
                'v-model'   => 'friendly_message_card'
            ]) !!}
            Agregar <a href="{{route("client::pages.show","tarjeta-impresa") }}" target="_blank" class="checkout__link">Tarjeta impresa con mensaje</a> (${{ number_format($print_message_const, 2, '.', ',') }})
        </label>
    </div>
</div>
