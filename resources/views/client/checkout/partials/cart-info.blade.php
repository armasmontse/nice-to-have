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

    @if ($bag->bagShipping && $bag->bagShipping->address && $bag->bagShipping->address->phone)
        <p class="checkout__title checkout__title-order">
            Teléfono:
            <span class="checkout__text checkout__text-order">
                {{$bag->bagShipping->address->phone  }}
            </span>
        </p>
    @endif

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
            Mesa de regalos:
            <span class="checkout__text checkout__text-order">{{$bag->event->name}}</span>
        </p>

        <p class="checkout__title checkout__title-order">
            No. de mesa de regalo:
            <span class="checkout__text checkout__text-order checkout__text-order--number">{{$bag->event->key}}</span>
        </p>
        <br><br><br>
	@endif
</div>


@if ($bag->bagShipping)
    <div class="checkout__title-container--md">
        <span class="checkout__title">Información de envío</span>
    </div>

    <div class="checkout__order-container">
        <p class="checkout__title checkout__title-order">
            Número guía:
            <span class="checkout__text checkout__text-order">
                {{ empty($bag->bagShipping->tracking_code) ? 'Sin asignar' :$bag->bagShipping->tracking_code }}
            </span>
        </p>

        <p class="checkout__title checkout__title-order">
            Método:
            <span class="checkout__text checkout__text-order">
                {{ empty($bag->bagShipping->method) ? 'No hay un método seleccionado' :$bag->bagShipping->method }}
            </span>
        </p>

        <p class="checkout__title checkout__title-order">
            Estatus:
            <span class="checkout__text checkout__text-order">
                {!! empty( $bag->bagShipping->info ) ? 'No hay información para mostrar' : $bag->bagShipping->info !!}
            </span>
        </p>
        <br><br><br>

        @if ($bag->bagShipping->address->contact_name)
            <p class="checkout__title checkout__title-order">
                Nombre:
                <span class="checkout__text checkout__text-order">
                    {{$bag->bagShipping->address->contact_name  }}
                </span>
            </p>
        @endif

        @if ($bag->bagShipping->address->phone)
            <p class="checkout__title checkout__title-order">
                Teléfono:
                <span class="checkout__text checkout__text-order">
                    {{$bag->bagShipping->address->phone  }}
                </span>
            </p>
        @endif

        {{-- @if ($bag->bagShipping->address->email)
            <p class="checkout__title checkout__title-order">
                Email:
                <span class="checkout__text checkout__text-order">
                     {{$bag->bagShipping->address->email  }}
                </span>
            </p>
        @endif --}}



        <p class="checkout__title checkout__title-order">
            Dirección:
            <span class="checkout__text checkout__text-order">
                {{$bag->bagShipping->address->street1  }}, {{$bag->bagShipping->address->street3  }}, {{$bag->bagShipping->address->street2  }}, {{$bag->bagShipping->address->city  }}, {{$bag->bagShipping->address->state  }}, {{$bag->bagShipping->address->country->official_name  }}, {{$bag->bagShipping->address->zip  }}
            </span>
        </p>
        <br>
        @if ($bag->bagShipping->address->references)
            <p class="checkout__title checkout__title-order">
                Referencias:
                <span class="checkout__text checkout__text-order">
                    {{ $bag->bagShipping->address->references  }}
                </span>
            </p>
        @endif
    </div>
@endif
