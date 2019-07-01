<div class="checkout__input-container">
    {!! Form::text('', null, [
        'class'         => 'input checkout__input',
        'required'      => 'required',
        // 'form'          => 'checkout_form',
        'placeholder'   => 'Nombre como aparece en la tarjeta',
        'v-model'       => 'store.creditCardDetails.name'
    ]) !!}

    {!! Form::text('', null, [
        'class'         => 'input checkout__input',
        'required'      => 'required',
        // 'form'          => 'checkout_form',
        'placeholder'   => 'Número de tarjeta',
        'v-model'       => 'store.creditCardDetails.number'
    ]) !!}

    {!! Form::number('', null, [
        'class'         => 'input checkout__input',
        'required'      => 'required',
        // 'form'          => 'checkout_form',
        'min'           => '1',
        'max'           => '12',
        'step'          => '1',
        'placeholder'   => 'Mes de vencimiento',
        'v-model'       => 'store.creditCardDetails.exp_month'
    ]) !!}

    {!! Form::number('', null, [
        'class'         => 'input checkout__input',
        'required'      => 'required',
        // 'form'          => 'checkout_form',
        'min'           => date("Y"),
        'max'           => (date("Y")+15),
        'step'          => '1',
        'placeholder'   => 'Año de vencimiento',
        'v-model'       => 'store.creditCardDetails.exp_year'
    ]) !!}

    {!! Form::text('', null, [
        'class'         => 'input checkout__input',
        'required'      => 'required',
        // 'form'          => 'checkout_form',
        'maxlength'     => '4',
        'pattern'       => "[a-zA-Z0-9\s]+",
        'placeholder'   => 'Código de seguridad',
        'v-model'       => 'store.creditCardDetails.cvc'
    ]) !!}
</div>
