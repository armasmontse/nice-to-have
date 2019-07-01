@extends('layouts.client', ['body_id'	=> 	'main-vue'])

@section('title')
    | Confirmación de compra
@endsection

@section('content')
    <div class="grid__row">
        <div class="grid__container--full-width checkout__container checkout__container-mb">
            <div class="grid__col-1-1">
                @include('client.general.page-title', ['title' => 'confirmación de orden de pago'])
            </div>
        </div>

        @if (session('just_buy'))
            <div class="grid__container--full-width checkout__container-mb">
                <div class="grid__col-1-1">

                    <div class="page-title__title-container">
                        <div class="checkout__title-italic">
                            {!! $thank_you_page_gratitude_alert_copy !!}
                        </div>
                        <br>

                        @unless ($products_to_buy)
                            <div class="checkout__title-italic">
                                {!! $thank_you_page_ramaining_products_copy !!}
                            </div>

                            <br>

                            <div class="checkout__button-container">
                                <a href="{{ route("client::bags.index") }}" class="input__submit"  >ir a carrito</a>
                            </div>
                        @endunless
                    </div>
                    <div class="divisor"></div>
                </div>
            </div>
        @endif


        <div class="grid__container">
            <div class="grid__col-1-2-uneven grid__col-1-2-uneven--lg checkout__col-1-2-uneven">
                <div class="grid__box checkout__box-right-thanks">
                    @include('client.checkout.partials.cart-info')
                </div>
            </div>

            <div class="grid__col-1-2-uneven grid__col-1-2-uneven--sm checkout__col-1-2-uneven">
                <div class="grid__box checkout__box checkout__box-left-thanks">

                    @include('client.checkout.partials.cart')

                    <div class="checkout__bill-container checkout__bill-container--mb">
                        <div class="shopping-cart__bill-container">
                            <span class="shopping-cart__text shopping-cart__text-grey">subtotal:</span>
                            <span class="shopping-cart__text-price">$ {{ number_format($bag_totals["subtotal"],2) }} {{ $bag->bagPayment->currency_type }}</span>
                        </div>

                        <div class="shopping-cart__bill-container">
                            <span class="shopping-cart__text shopping-cart__text-grey">i.v.a.</span>
                            <span class="shopping-cart__text-price">$ {{ number_format($bag_totals["iva"],2) }} {{ $bag->bagPayment->currency_type }}</span>
                        </div>

						@unless(empty($bag_totals["envio"]))
                            <div class="shopping-cart__bill-container">
                                <span class="shopping-cart__text shopping-cart__text-grey">costo de envío:</span>
                                <span class="shopping-cart__text-price">$ {{ number_format($bag_totals["envio"],2) }} {{ $bag->bagPayment->currency_type }} </span>
                            </div>
                        @endunless

                        @if ($bag->print_message)
                            <div class="shopping-cart__bill-container" >
                                <span class="shopping-cart__text shopping-cart__text-grey">Tarjeta Impresa:</span>

                                <span class="shopping-cart__text-price">$ {{ number_format($bag_totals["print_message"],2) }} {{ $bag->bagPayment->currency_type }} </span>
                            </div>
                        @endif

						@unless (empty($bag_totals["total_credit"]))
							<div class="shopping-cart__bill-container" >
								<span class="shopping-cart__text shopping-cart__text-grey">Saldo en mesa de regalos:</span>

								<span class="shopping-cart__text-price">$ {{ number_format($bag_totals["total_credit"],2) }} {{ $bag->bagPayment->currency_type }} </span>
							</div>
						@endunless

                        @unless(empty($bag_totals["discount"]))
                            <div class="shopping-cart__bill-container">
                                <span class="shopping-cart__text shopping-cart__text-grey">Descuento:</span>
                                <span class="shopping-cart__text-price">$ {{ number_format($bag_totals["discount"],2) }} {{ $bag->bagPayment->currency_type }} </span>
                            </div>
                        @endunless

                        {{-- @if ($stock_movement->saleDiscount)
                            <div class="shopping-cart__bill-container" >
                                <span class="shopping-cart__text shopping-cart__text-grey">{{trans("bag.discount_code")}}</span>
                                <span class="shopping-cart__text-price">- ${{ number_format($stock_movement->saleDiscount->amount/$stock_movement->salePayment->currency,2) }} {{ $stock_movement->salePayment->currency_type }}</span>
                            </div>
                        @endif --}}

                        <div class="shopping-cart__bill-container">
                            <span class="shopping-cart__text shopping-cart__text">total:</span>
                            <span class="shopping-cart__text-price shopping-cart__text-price-black">$ {{ number_format( array_sum($bag_totals) ,2) }}  {{ $bag->bagPayment->currency_type }} </span>
                        </div>

                    </div>

                    <div class="divisor"></div>


                    @if (!$bag->bagType->event && !$bag->bagType->register_user ) {{-- solo para compra personal --}}
                        <div class="checkout__button-container">
                            <a href="{{ route("user::bag.thankyou-page.billing:get",[$user->name,$bag->key]) }}" class="input__submit"  >Factura Fiscal</a>
                        </div>
                    @endif

                    <div class="checkout__button-container">
                        <a href="" class="input__submit" onclick="javascript:window.print()">Imprimir Recibo</a>
                    </div>

                </div>
            </div>
        </div>

        {{-- @include('client.checkout.partials.pay-items') --}}
    </div>
@endsection

@section('vue_templates')
	@include('client.shop.shop-product')
@endsection
