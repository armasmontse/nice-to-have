<div class="checkout__title-container--md">
    <span class="checkout__title">orden de compra</span>
</div>

<div class="checkout__order-container">
    <p class="checkout__title checkout__title-order">
        fecha:
        <span class="checkout__text checkout__text-order">{{ $bag->purshased_at->format("d/m/Y") }}</span>
    </p>

    <p class="checkout__title checkout__title-order">
        no. de compra:
        <span class="checkout__text checkout__text-order checkout__text-order--number">{{ $bag->key }}</span>
    </p>

    <p class="checkout__title checkout__title-order">
        a nombre de:
        <span class="checkout__text checkout__text-order">{{$bag->bagUser->name}}</span>
    </p>

    <br><br><br>

    @if (strpos($bag->bagPayment->payable_type, 'spei') !== false)
        <p class="checkout__title checkout__title-order">
            Método de pago:
            <span class="checkout__text checkout__text-order">SPEI</span>
        </p>

        <p class="checkout__title checkout__title-order">
            Banco:
            <span class="checkout__text checkout__text-order checkout__text-order--number">{{ $bag->bagPayment->extra_info["bank"] }}</span>
        </p>

        <p class="checkout__title checkout__title-order">
            CLABE:
            <span class="checkout__text checkout__text-order checkout__text-order--number">{{ $bag->bagPayment->extra_info["clabe"] }}</span>
        </p>
    @else
        <p class="checkout__title checkout__title-order">
            Método de pago:
            <span class="checkout__text checkout__text-order">
                @if (strpos($bag->bagPayment->payable_type, 'paypal') !== false)
                    Paypal
                @elseif (strpos($bag->bagPayment->payable_type, 'gift_table_payment') !== false  )
                    Saldo
                @else
                    Tarjeta
                @endif
            </span>
        </p>
    @endif

    <p class="checkout__title checkout__title-order">
        Estatus de compra:
        <span class="checkout__text checkout__text-order">{{ $bag->bagStatus->label }}</span>
    </p>

    <br><br><br>

    @if ($bag->bagType->event)
        <p class="checkout__title checkout__title-order">
            Mesa de regalos de:
            <span class="checkout__text checkout__text-order">{{$bag->event->name}}</span>
        </p>

        <p class="checkout__title checkout__title-order">
            No. de mesa de regalo:
            <span class="checkout__text checkout__text-order checkout__text-order--number">{{$bag->event->key}}</span>
        </p>
    @else
        <p class="checkout__title checkout__title-order">
            Número guía:
            <span class="checkout__text checkout__text-order">{{ $bag->bagShipping->tracking_code or 'Sin asignar' }}</span>
        </p>

        <p class="checkout__title checkout__title-order">
            Método:
            <span class="checkout__text checkout__text-order">{{ $bag->bagShipping->method or 'No hay un método seleccionado' }}</span>
        </p>

        <p class="checkout__title checkout__title-order">
            Info:
            <span class="checkout__text checkout__text-order">{!! $bag->bagShipping->info or 'No hay información para mostrar' !!}</span>
        </p>

        <p class="checkout__title checkout__title-order">
            Dirección de envío:
            <span class="checkout__text checkout__text-order"> {{$bag->bagShipping->address->street1  }}, {{$bag->bagShipping->address->street3  }}, {{$bag->bagShipping->address->street2  }}, {{$bag->bagShipping->address->city  }}, {{$bag->bagShipping->address->state  }}, {{$bag->bagShipping->address->country->official_name  }}, {{$bag->bagShipping->address->zip  }}   </span>
        </p>
    @endif

</div>
