@extends('layouts.client', ['body_id'	=> 	'checkout-vue'])

@section('title')
	| Checkout
@endsection

@section('content')

	{!! Form::open([
		'method'                => 'post',
		'route'                 => ['client::bag.checkout:post', $bag->key],
		'role'                  => 'form' ,
		'id'                    => 'checkout_form',
		'v-on.submit.prevent"'  => 'post'
	]) !!}

		{{-- barra superior con titulo y pasos --}}
		<div class="grid__row">

			<div class="grid__container--full-width users__container-page-title">

				<div class="grid__col-1-1">
					<div class="grid__box">
						@include('client.general.page-title', ['title' => 'COMPRA']){{-- muahahahaha --}}
					</div>
				</div>

				{{-- Pasos --}}
				<div class="grid__container">
					<div class="grid__col-1-1">
						<div class="    shopping-cart__link-menu-container
						checkout__link-menu-container"
						>
							<span class="shopping-cart__link-menu">
								1. Registro
							</span>
							<span class='icon__caret-right'>{!! file_get_contents('images/icon-caret-right.svg') !!}</span>
							<span
								class="shopping-cart__link-menu"
								v-bind:class="{selected: step === 2}"
								@click.stop="step = 2"
							>
								2. Envio
							</span>
							<span class='icon__caret-right'>{!! file_get_contents('images/icon-caret-right.svg') !!}</span>
							<span
								class="shopping-cart__link-menu"
								v-bind:class="{selected: step === 3}"
								@click.stop="goToStep3"
							>
								3. Pago
							</span>
						</div>
						<div class="divisor"></div>
					</div>
				</div>

			</div>

		</div>

		<div class="grid__container">

			<div id="checkout_left_JS" class="grid__col-1-2 checkout__col-1-2 checkout__col-1-2--absolute-box">

				{{-- User and Recipient Info and custom message --}}
				<div class="grid__box checkout__box checkout__box-right {{-- checkout__box--absolute --}}" v-if="step === 2" :transition="'slide'">

					<div v-if="store.bag_event ===  null">

						<div class="checkout__checkbox-container checkout__checkbox-container--card">
						    <label for="accept_terms" class="input__checkbox-label checkout__checkbox-label">
						        {!! Form::radio('show_message_box', 0, null, [
						            'class'     => 'input__checkbox',
						            'v-model'   => 'show_message_box',
						            'id'        => 'accept_terms'
						        ]) !!}
						        Es para mi
						    </label>
						    <label for="show_message_box" class="input__checkbox-label checkout__checkbox-label">
						        {!! Form::radio('accept_terms', 1, null, [
						            'class'     => 'input__checkbox',
						            'v-model'   => 'show_message_box',
						            'id'        => 'show_message_box'
						        ]) !!}
						        Es un regalo para alguien más
						    </label>
						</div>

						<div v-if="show_message_box === '1' ">
							@include('client.checkout.variations.event-message')
						</div>

						<div class="divisor checkout__checkbox-container-divisor"></div>

						@if (!$bag->bagType->event)
							@include('client.checkout.partials.shipping-address',[
								"contact_name"  => $bag->bagType->register_user ? old("address.contact_name") : ($address ? $address->contact_name :  $user->full_name),
								"email"         => (!$bag->bagType->register_user && $address) ? $address->email :  old("address.email"),
								"phone"         => (!$bag->bagType->register_user && $address) ? $address->phone :  old("address.phone"),
								"street1"       => (!$bag->bagType->register_user && $address) ? $address->street1 :  old("address.street1"),
								"street2"       => (!$bag->bagType->register_user && $address) ? $address->street2 :  old("address.street2"),
								"street3"       => (!$bag->bagType->register_user && $address) ? $address->street3 :  old("address.street3"),
								"zip"           => (!$bag->bagType->register_user && $address) ? $address->zip :  old("address.zip"),
								"city"          => (!$bag->bagType->register_user && $address) ? $address->city :  old("address.city"),
								"state"         => (!$bag->bagType->register_user && $address) ? $address->state :  old("address.state"),
								"country_id"    => (!$bag->bagType->register_user && $address) ? $address->country_id :  old("address.country_id"),
								"references"    => (!$bag->bagType->register_user && $address) ? $address->references :  old("address.references"),
							])
						@endif

					</div>

					<div v-else>

						<div class="checkout__title-container">
							<h2 class="checkout__title">Envío:</h2>
						</div>

						<div class="checkout__title-container">
							<div class="checkout__title checkout__title--ttn">
								{!! $checkout_event_send_copy !!}
								{{-- Tus regalos llegarán a la dirección asignada para la mesa de regalos. Nosotros nos encargamos --}}
							</div>
						</div>

						<div class="divisor checkout__divisor"></div>

						@include('client.checkout.variations.event-message')

					</div>

				</div>

				<div class="grid__box checkout__box checkout__box-right checkout__box--absolute" v-if="step === 3" :transition="'slide'">

					@include('client.checkout.partials.personal-info')

					@include('client.checkout.partials.payment')

					@include('client.checkout.partials.discount-code')

					<div class="divisor checkout__divisor"></div>

				</div>

			</div>

			{{-- Shopping bagg --}}
			<div class="grid__col-1-2 checkout__col-1-2">

				<div class="grid__box checkout__box checkout__box-left">

					@include('client.checkout.partials.cart')

					<div class="checkout__title-container--xl">
						<span class="checkout__title">resumen de compra</span>
					</div>

					<div class="checkout__bill-container">
						  <shopping-bag-for-checkout
							:current-bag="store.current_bag"
							:bag-totals="store.bag_totals"
							:exchange-rate="store.exchange_rate"
							:iva="store.iva"
							:in-zona-metropolitana="inZonaMetropolitana"
							:is-shopping-bag="false"
							:friendly-message-card="friendly_message_card"
							:is-event="store.is_event_checkout"
							:discount-info="store.discount"
						></shopping-bag-for-checkout>
					</div>

					@include('client.checkout.partials.submit')

				</div>

			</div>

		</div>

		<input type="hidden" form="checkout_form" name="print_message" v-model="friendly_message_card" v-if="friendly_message_card">
		<input type="hidden" form="checkout_form" name="message" v-model="friendly_message">

		{{--  Discount Code --}}
		<input type="hidden" form="checkout_form" name="discount_code" v-model="discount_code">
		{{--  /Discount Code --}}

		{{--  Shipping Address --}}
		<input type="hidden" form="checkout_form" name="address[email]" v-model="store.shippingAddress.email">
		<input type="hidden" form="checkout_form" name="address[contact_name]" v-model="store.shippingAddress.contact_name">
		<input type="hidden" form="checkout_form" name="address[phone]" v-model="store.shippingAddress.phone">
		<input type="hidden" form="checkout_form" name="address[country_id]" v-model="store.shippingAddress.country_id">
		<input type="hidden" form="checkout_form" name="address[state]" v-model="store.shippingAddress.state">
		<input type="hidden" form="checkout_form" name="address[city]" v-model="store.shippingAddress.city">
		<input type="hidden" form="checkout_form" name="address[street1]" v-model="store.shippingAddress.street1">
		<input type="hidden" form="checkout_form" name="address[street2]" v-model="store.shippingAddress.street2">
		<input type="hidden" form="checkout_form" name="address[street3]" v-model="store.shippingAddress.street3">
		<input type="hidden" form="checkout_form" name="address[zip]" v-model="store.shippingAddress.zip_code">
		<input type="hidden" form="checkout_form" name="address[references]" v-model="store.shippingAddress.references">
		<input type="hidden" form="checkout_form" v-model="inZonaMetropolitana" name="in_zona_metropolitana">
		{{--  /Shipping Address --}}

		{{-- Conekta and Credit Card --}}
		<input type="hidden" name="conekta_token" form="checkout_form" v-model="conekta.token.id" v-bind:disabled="!new_card">
		<input type="hidden" name="card[last_digits]" form="checkout_form" v-model="store.creditCardDetails.last_digits" v-bind:disabled="!new_card">
		<input type="hidden" name="card[provider]" form="checkout_form" v-model="store.creditCardDetails.provider_key" v-bind:disabled="!new_card">
		{{-- /Conekta and Credit Card --}}

	{!! Form::close() !!}

	{{-- formas escondidas --}}
	<form action="post" id="conekta">
		<input type="hidden" name="card[number]" v-model="store.creditCardDetails.number">
		<input type="hidden" name="card[name]" v-model="store.creditCardDetails.name">
		<input type="hidden" name="card[cvc]" v-model="store.creditCardDetails.cvc">
		<input type="hidden" name="card[exp_month]" v-model="store.creditCardDetails.month">
		<input type="hidden" name="card[exp_year]" v-model="store.creditCardDetails.year">
	</form>

	{!! Form::open([
	    'method'                => 'POST',
	    'route'                 => ['client::bag.ajax.validateDiscountCode', $bag->id],
	    'role'                  => 'form' ,
	    ':id'                    => 'discount_code_form_id',
	]) !!}

		<input type="hidden" :form="discount_code_form_id" name="discount_code" v-model="discount_code">

	{!! Form::close() !!}

@endsection

@section('conekta_script')
	<script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.3.2/js/conekta.js"></script>
	<script>
		Conekta.setPublishableKey('{{ env('CONEKTA_PUBLIC_KEY') }}');
	</script>
@endsection

@section('vue_templates')
	<script type="x/templates" id="shopping-bag-for-checkout-template">
		<div>
			@include('client.shopping-cart.partials.bill')

			<input type="hidden" name="order_total" v-model="order_total" form="checkout_form">
		</div>
	</script>
@endsection

@section('vue_store')
	<script>
		mainVueStore.register_user = {!! json_encode($bag->bagType->register_user) !!}//para identificar si el regalo es para alguien más
		mainVueStore.preloaded_country_id = '{{ (!$bag->bagType->register_user && $address) ? $address->country_id :  old("address.country_id") }}';
		mainVueStore.preloaded_municipio = '{{ (!$bag->bagType->register_user && $address) ? $address->street2 :  old("address.street2") }}';
		mainVueStore.friendly_message_card_price = {{ $print_message_const }}
		mainVueStore.user_cards = {!!json_encode($cards)!!}
		mainVueStore.bag_event = {!! json_encode($bag->event) !!}
		mainVueStore.states_and_mun = {!! json_encode($mexico_states_and_mun) !!}
		mainVueStore.bag_totals = {!! json_encode($bag->bag_totals) !!}
		mainVueStore.is_event_checkout = {!! json_encode($bag->bagType->event) !!}
		mainVueStore.discount_code = {!! json_encode('') !!}
		mainVueStore.discount_codes_types= {!! json_encode($discount_codes_types) !!}
	</script>
@endsection
