<div class="checkout__data-container">
    <div class="checkout__title-container--lg">
        <span class="checkout__title">{{isset($title) ? $title : "datos del destinatario"}}</span>
    </div>



    <div class="checkout__input-container">


        {!! Form::email('address[email]', $email, [
            'class'         => 'input checkout__input',
            'placeholder'   => 'Correo electrónico',
           'form'          => isset($form) ? $form : '',
            'v-model'    =>     'store.shippingAddress.email',
            'required' => 'required'
        ]) !!}
        {{-- <div class="checkout__input-hide" v-if="!hide_invalid_email_message">
            <span class="checkout__text">Favor de ingresar un email válido</h4>
        </div> --}}


        {!! Form::text('address[contact_name]', $contact_name, [
            'class'         => 'input checkout__input',
            'required'      => 'required',
            'placeholder'   => 'Nombre de contacto',
            'form'          => isset($form) ? $form : '',
            'v-model'       => 'store.shippingAddress.contact_name'
        ]) !!}

        {!! Form::text('address[phone]', $phone, [
            'class'         => 'input checkout__input',
            'required'      => 'required',
            'placeholder'   => 'Teléfono de contacto',
            'form'          => isset($form) ? $form : '',
            'v-model'       => 'store.shippingAddress.phone'
        ]) !!}

        <div class="input__select-container checkout__select-container">
            <select class="input__select checkout__select"
                    required="required"
                    form="{{ isset($form) ? $form : ''}}"
                    name="address[country_id]"
                    v-model='store.shippingAddress.country_id'
                >
                <option value="-1">País</option>

                @foreach ($countries_list as $key => $country)
                    <option value="{{$key}}"  {{$key == $country_id ? "selected" : ""}} >{{$country}} </option>
                @endforeach
            </select>
            <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
        </div>

        <div class="input__select-container checkout__select-container">
            <select class="input__select checkout__select"
                    required="required"
                    form="{{ isset($form) ? $form : ''}}"
                    name="address[state]"
                    v-model='store.shippingAddress.state'
                >
                <option value="-1" >Estado</option>

                @foreach ($mexico_states_and_mun as $key => $mexico_state)
                    <option value="{{$key}}"  {{$key == $state ? "selected" : ""}} >{{$key}} </option>
                @endforeach
            </select>
            <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
        </div>

        {!! Form::text('address[city]', $city, [
            'class'         => 'input checkout__input',
            'required'      => 'required',
            'placeholder'   => 'Ciudad',
           'form'          => isset($form) ? $form : '',
            'v-model'       =>  'store.shippingAddress.city'
        ]) !!}


        <div class="input__select-container checkout__select-container" style="margin-bottom: 10px;">
            <select class="input__select checkout__select"
                    required="required"
                    form="{{ isset($form) ? $form : ''}}"
                    name="address[street2]"
                    v-model="store.shippingAddress.street2"
                    >
                <option value="-1">Delegación / Municipio</option>
                <option :value="municipio['NOM_MUN,C,110']" v-for="municipio in municipios">@{{municipio['NOM_MUN,C,110']}}</option>

            </select>
            <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
        </div>
        <br>

        {!! Form::text('address[street1]', $street1, [
            'class'         => 'input checkout__input',
            'required'      => 'required',
            'placeholder'   => 'Calle, número interior y número exterior',
            'form'          => isset($form) ? $form : '',
            'v-model'       =>  'store.shippingAddress.street1'
        ]) !!}



        {!! Form::text('address[street3]', $street3, [
            'class'         => 'input checkout__input',
            'required'      => 'required',
            'placeholder'   => 'Colonia',
            'form'          => isset($form) ? $form : '',
            'v-model'       =>  'store.shippingAddress.street3'
        ]) !!}


        {!! Form::text('address[zip]', $zip, [
            'class'         => 'input checkout__input',
            'required'      => 'required',
            'placeholder'   => 'Código postal',
            'form'          => isset($form) ? $form : '',
            'v-model'       =>  'store.shippingAddress.zip_code',
        ]) !!}


        {!! Form::textarea('address[references]', $references, [
            'class'         => 'input__textarea checkout__input-textarea--lg',
            'placeholder'   => 'Referencias',
            'form'          => isset($form) ? $form : '',
            'style'         => 'margin-top: 10px;',
            'v-model'       => 'store.shippingAddress.references'
        ]) !!}

    </div>
</div>
