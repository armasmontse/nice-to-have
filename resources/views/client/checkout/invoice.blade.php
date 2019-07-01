{{-- @extends('layouts.client', ['body_id'    =>     'invoice-vue']) --}}

@section('title')
    | Facturación
@endsection

@section('content')
    <div class="grid__row">
        <div class="grid__container--full-width checkout__container checkout__container-mb">
            <div class="grid__col-1-1">
                @include('client.general.page-title', ['title' => 'facturación de compra'])
            </div>
        </div>


            {!! Form::open([
                    'method'                => 'post',
                    'route'                 => ['user::bag.thankyou-page.billing:post',$user->name, $bag->key],
                    'role'                  => 'form' ,
                    'id'                    => 'create_billing_form',
                    "class"                 => ''
                ]) !!}
                <div class="grid__container">
                    <div class="grid__col-1-2 checkout__col-1-2">
                        <div class="grid__box checkout__box checkout__box-right-invoice">
                            <div class="checkout__title-container--invoice" >
                                <span class="checkout__title">datos de facturación</span>
                            </div>

                            @if ($bag_billing)
                                @include('client.checkout.variations.invoice-info')
                            @else
                                @include('client.checkout.variations.invoice-form')
                            @endif
                        </div>
                    </div>


                    @if (!$bag_billing)
                        <div class="grid__col-1-2 checkout__col-1-2">
                            <div class="grid__box checkout__box checkout__box-left-invoice">
                                <div class="checkout__title-container--invoice">
                                    <span class="checkout__title">tu factura será enviada al correo</span>
                                </div>

                                <div class="checkout__button-invoice-container">
                                    {!! Form::submit('enviar datos', [
                                        'class' => 'input__submit',
                                        'form'  => 'create_billing_form',
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    @endif
                </div>

            {!! Form::close() !!}

        {{-- @include('client.checkout.partials.pay-items') --}}
    </div>
@endsection

@section('vue_store')
    <script>
        mainVueStore.preloaded_country_id = '{{ old("address.country_id") }}';
        mainVueStore.preloaded_municipio = '{{ old("address.street2") }}';
        mainVueStore.states_and_mun = {!! json_encode($mexico_states_and_mun) !!}
    </script>
@endsection
