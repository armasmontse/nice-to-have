<div {{-- v-if="show_billing" --}}>
    {!! Form::open([
            'method'                => 'post',
            // 'action'                => ['Bag\BillingController@store', $stock_movement->key],
            'role'                  => 'form' ,
            'id'                    => 'create_billing_form',

        ]) !!}
        <div class="checkout__input-container">
            {!! Form::text('rfc', old("rfc"), [
                'class'         => 'input checkout__input',
                'required'      => 'required',
                'placeholder'   => 'R.F.C',
                'form'          => 'create_billing_form',

            ]) !!}

            {!! Form::text('razon_social', old("razon_social") , [
                'class'         => 'input checkout__input',
                'required'      => 'required',
                'placeholder'   => 'Razón social',
                'form'          => 'create_billing_form',

            ]) !!}

            {!! Form::textarea('info', old("info"), [
                'class'         => 'input__textarea checkout__input-textarea--lg',
                'placeholder'   => 'Info',
                'form'          => 'create_billing_form',
                'rows'          => 2,
            ]) !!}

            {!! Form::text('address[contact_name]', old("address.contact_name"), [
                'class'         => 'input checkout__input',
                'required'      => 'required',
                'placeholder'   => 'Nombre',
                'form'          => 'create_billing_form',
                'v-model'       => 'store.shippingAddress.contact_name'
            ]) !!}

            {!! Form::text('address[phone]', old("address.phone"), [
                'class'         => 'input checkout__input',
                'required'      => 'required',
                'placeholder'   => 'Teléfono',
                'form'          => 'create_billing_form',
                'v-model'       => 'store.shippingAddress.phone'
            ]) !!}

            <div class="input__select-container checkout__select-container">
                <select class="input__select checkout__select"
                        required="required"
                        form="create_billing_form"
                        name="address[country_id]"
                        v-model='store.shippingAddress.country_id'
                    >
                    <option value="-1">País</option>

                    @foreach ($countries_list as $key => $country)
                        <option value="{{$key}}"  {{$key == old("address.country_id") ? "selected" : ""}}  >{{$country}} </option>
                    @endforeach
                </select>
                <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
            </div>

            <div class="input__select-container checkout__select-container">
                <select class="input__select checkout__select"
                        required="required"
                        form="create_billing_form"
                        name="address[state]"
                        v-model='store.shippingAddress.state'
                    >
                    <option value="-1" >Estado</option>

                    @foreach ($mexico_states_and_mun as $key => $mexico_state)
                        <option value="{{$key}}"   {{$key == old("address.state") ? "selected" : ""}} >{{$key}} </option>
                    @endforeach
                </select>
                <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
            </div>

            {!! Form::text('address[city]', old("address.city"), [
                'class'         => 'input checkout__input',
                'required'      => 'required',
                'placeholder'   => 'Ciudad',
                'form'          => 'create_billing_form',
                'v-model'       =>  'store.shippingAddress.city'
            ]) !!}

            <div class="input__select-container checkout__select-container" style="margin-bottom: 10px;">
                <select class="input__select checkout__select"
                        required="required"
                        form="create_billing_form"
                        name="address[street2]"
                        v-model="store.shippingAddress.municipio"
                        >
                    <option value="-1" >Delegación / Municipio</option>
                    <option :value="municipio['NOM_MUN,C,110']" v-for="municipio in municipios">@{{municipio['NOM_MUN,C,110']}}</option>

                </select>
                <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
            </div>
            <br>

            {!! Form::text('address[street1]', old("address.street1"), [
                'class'         => 'input checkout__input',
                'required'      => 'required',
                'placeholder'   => 'Calle, número interior y número exterior',
                'form'          => 'create_billing_form',
                'v-model'       =>  'store.shippingAddress.street1'
            ]) !!}



            {!! Form::text('address[street3]', old("address.street3"), [
                'class'         => 'input checkout__input',
                'required'      => 'required',
                'placeholder'   => 'Colonia',
                'form'          => 'create_billing_form',
                'v-model'       =>  'store.shippingAddress.street3'
            ]) !!}


            {!! Form::text('address[zip]', old("address.zip"), [
                'class'         => 'input checkout__input',
                'required'      => 'required',
                'placeholder'   => 'Código postal',
                'form'          => 'create_billing_form',
                'v-model'       =>  'store.shippingAddress.zip_code',
            ]) !!}


            {!! Form::textarea('address[references]', old("address.references"), [
                'class'         => 'input__textarea checkout__input-textarea--lg',
                // 'required'      => 'required',
                'placeholder'   => 'Referencias / Horario de envío de preferencial',
                'form'          => 'create_billing_form',
                'style'         => 'margin-top: 10px;',
                'v-model'       => 'store.shippingAddress.references'
            ]) !!}
        </div>
    {!! Form::close() !!}

    <div class="divisor"></div>
</div>
