<div class="checkout__data-container">
    <div class="checkout__title-container">
        <span class="checkout__title">tu información:</span>
    </div>

    <div class="checkout__input-container">
        {!! Form::text('first_name', $user->first_name , [
            'class'         => 'input checkout__input',
            'placeholder'   => 'Nombre',
            'form'          => 'checkout_form',
            'required'      => 'required',
            'v-model'       => 'store.shippingAddress.name'
            ])
        !!}

        {!! Form::text('last_name', $user->last_name , [
            'class'         => 'input checkout__input',
            'placeholder'   => 'Apellidos',
            'form'          => 'checkout_form',
            'required'      => 'required',
            'v-model'       => 'store.shippingAddress.last_name'
            ])
        !!}

        {!! Form::text('phone', $user->phone , [
            'class'         => 'input checkout__input',
            'placeholder'   => '55-5555-5555',
            'form'          => 'checkout_form',
            'required'      => 'required',
            'v-model'       => 'store.shippingAddress.contact_phone'
            ])
        !!}
    </div>
    <div class="divisor"></div>
</div>
