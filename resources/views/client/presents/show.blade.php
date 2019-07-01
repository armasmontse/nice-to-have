@extends('layouts.client', ['body_id'	=> 	'checkout-vue'])

@section('title')
    | Regalos para {{ ucwords($bag->bagUser->user->full_name) }}
@endsection

@section('content')
    <div class="grid__row">

        @include('client.general.page-title', ['title' => '¡Felicidades!'])

        <div class="grid__container">

            <div class="grid__col-1-1">

                <div class="grid__container userEvent__intro" style="margin-top: 70px;">
                    <p class="shopping-cart__text">
                        {{ ucwords($bag->bagUser->user->full_name) }} ({{ $bag->bagUser->user->email }}) te ha regalado los siguientes productos el {{ $bag->purshased_at->format('d/m/y') }} en nicetohave.com.mx:
                        <br><br>
                        <span class="shopping-cart__text shopping-cart__text-grey" style="width: 100%;">
                            Tus regalos llegarán pronto a:
                            {{$bag->bagShipping->address->street1  }}, {{$bag->bagShipping->address->street3  }}, {{$bag->bagShipping->address->street2  }}, <br>
                            {{$bag->bagShipping->address->city  }}, {{$bag->bagShipping->address->state  }}, {{$bag->bagShipping->address->country->official_name  }}, {{$bag->bagShipping->address->zip  }}
                        </span>
                        <br><br>
                        @if ($bag->message)
                            <span class="shopping-cart__text shopping-cart__text-grey">
                                Mensaje de {{ ucwords($bag->bagUser->user->name) }}: <br>
                                {!! nl2br($bag->message) !!}
                            </span>
                        @endif
                    </p>
                </div>

            </div>

            <div class="grid__container">

                @foreach ($skus as $sku)

                    <div class="grid__col-1-2">

                        <div class="grid__container--full-width single__container">

                            <div class="grid__col-1-2 single__col-1-2 h-initial">
                        		<div class="shopping-cart__box--single">
                        			<a href="{{ $sku->product->clientUrl }}" target="_blank">
                        				<div class="shopping-cart__bg-img shopping-cart__bg-img--full-height" style="background-image: url('{{ $sku->thumbnail_image->url }}')"></div>
                        			</a>
                        		</div>
                        	</div>

                        	<div class="grid__col-1-2 single__col-1-2 {{isset($special_col_right) ? $special_col_right : ''}}">

                                <div class="single__info-box">

                                    <h2 class="single__ttl single__ttl--sm"><a href="{{ $sku->product->clientUrl }}">{{ $sku->product->title }}</a></h2>

                        			<div class="single__container--sm">

                                        <div class="shopping-cart__selected-variation">
                        					<p class="single__input-label single__input-label--pointer">
                        						variación
                        					</p>
                        					<p class="single__description--selected-variant truncate-single_JS">{{ $sku->description }}</p>
                        				</div>

                                        {{-- Cantidad --}}
                        		    	<div class="single__container--sm-cart">
                        					<div class="single__input-container flex-cont--sb">
                        						<label for="quantity" class="single__input-label single__input-label--uppercase">Cantidad:</label>
                        						<span class="single__input-label">{{ $sku->pivot->quantity }}</span>
                        					</div>
                        		    	</div>

                                        {{--Prices --}}
                    		    		{{-- <div class="single__price-container single__price-container--mb-sm">
                    		    			<p class="single__price--label">precio:</p>
                    		    			<p class="single__price single__price--sm">${{ number_format($sku->pivot->price * (1-$sku->pivot->discount/100), 2, '.', ',') }}</p>
                    		    		</div>

                    		    		<div class="single__price-container single__price-container--right single__price-container--mb-sm">
                    		    			@if(! is_page('user::wishlist.index'))
                    			    			<p class="single__price--label">precio total:</p>
                    		    				<p class="single__price single__price--sm">${{ number_format($sku->pivot->price * (1-$sku->pivot->discount/100) * $sku->pivot->quantity, 2, '.', ',') }}</p>
                    		    			@endif
                    		    		</div> --}}

                        			</div>

                        		</div>

                        	</div>

                        </div>

                    </div>

                @endforeach

            </div>

            <div class="grid__col-1-1">
    			@include('client.general.scroll-up-icon')
    		</div>

        </div>

    </div>
@endsection
