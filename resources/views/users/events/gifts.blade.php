@extends('layouts.client')

@section('title')
    | Mensajes y Regalos
@endsection

@section('content')

<div class="grid__row">
	@include('users.events.general.head')

	<div class="grid__container">
		<div class="grid__container">
            @if($bags->isEmpty()){{-- Si está vacia la lista de regalos  --}}
    			<div class="grid__col-1-1 text-center">
    			    <div class="shopping-cart__item-total-container shopping-cart__item-total-container--mb-lg" >
    			        <p class="shopping-cart__text">
    			            Tu lista de regalos está vacía.<br>Comparte tu evento para comenzar a recibir regalos
    			        </p>
    			    </div>
    			</div>
            @else
                @foreach ($bags as $bag)
                    @foreach ($bag->skus as $sku)
                        <div class="grid__col-1-2">
                            @include('client.single.vue.single-product-info-template--user-gifts-variation', ['sku' => $sku])
                        </div>
                    @endforeach
                @endforeach
            @endif
		</div>

		<div class="grid__col-1-1">
			{{-- Botón ScrollUp --}}
			@include('client.general.scroll-up-icon')
		</div>
	</div>
</div>
@endsection
