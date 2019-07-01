@extends('layouts.client', ['body_id'	=> 	'checkout-event-vue'])

@section('title')
	| Checkout
@endsection

@section('content')

	{!! Form::open([
		'method'                => 'post',
		'route'                 => ['user::events.bag.checkout:post', $user->name, $personal_event->slug],
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
								3. @{{is_deposit ? 'Depósito' : 'Pago'}}
							</span>
						</div>
						<div class="divisor"></div>
					</div>
				</div>

			</div>

		</div>

		<div class="grid__container">

			<div id="checkout_left_JS" class="grid__col-1-2 checkout__col-1-2 checkout__col-1-2--absolute-box">

				{{-- Shipping Info --}}
				<div class="grid__box checkout__box checkout__box-right checkout__box--absolute" v-if="step === 2" :transition="'slide'">
					<div>
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
					</div>
				</div>

				<div class="grid__box checkout__box checkout__box-right checkout__box--absolute" v-if="step === 3" :transition="'slide'">

					@include('client.checkout.partials.personal-info')

					<div v-if="!is_deposit">
						@include('client.checkout.partials.payment')
					</div>

					<div v-else>
						{{-- Bank Accounts --}}
						<div class="checkout__title-container--xl">
							<span class="checkout__title">Cuenta bancaria para depósito</span>
						</div>
						@if ($user->bank_accounts->count() > 0)
							{{-- Cuentas existentes --}}
							@foreach ($user->bank_accounts as $bank_account)
								<span class="userEvent__input--row">
									{!! Form::radio('bank_account_id',$bank_account->id,null, [
										'class'		=> 'input__radio',
										'id'		=> 'bank_account-'.$bank_account->id,
										'v-model'		=> 'store.bankAccount.bank_account_id',
									]) !!}
									<label for="bank_account-{{$bank_account->id}}" class="userEvent__paragraph">
										<span class="users__text--data users__text--data-bank">NOMBRE: {{ $bank_account->name }}</span>
										<span class="users__text--data users__text--data-bank">BANCO: {{ $bank_account->bank }}</span>
										<span class="users__text--data users__text--data-bank">SURCURSAL: {{ $bank_account->branch }}</span>
										<span class="users__text--data users__text--data-bank">CUENTA: {{ $bank_account->account_number }}</span>
										<span class="users__text--data users__text--data-bank">CLABE: {{ $bank_account->displayCLABE() }}</span>
									</label>
								</span>
							@endforeach
							{{-- Nueva cuenta --}}
							<span class="userEvent__input--row">
								{!! Form::radio('bank_account_id','new_account',null, [
									'class'		=> 'input__radio',
									'v-model'		=> 'store.bankAccount.bank_account_id',
								]) !!}
								<label for="bank_account-0" class="userEvent__paragraph">
									<span class="users__text--data users__text--data-bank">Agregar nueva cuenta</span>
								</label>
							</span>
							<div class="mb3m" v-if="store.bankAccount.bank_account_id === 'new_account'">
								<input class="input form-control userEvent__input"
									type="text"
									placeholder="Banco"
									name="bank_account[bank]"
									form = "checkout_form"
									v-model="store.bankAccount.bank">

								<input class="input form-control userEvent__input"
									type="text"
									placeholder="Sucursal"
									name="bank_account[branch]"
									form = "checkout_form"
									v-model="store.bankAccount.branch">

								<input class="input form-control userEvent__input"
									type="text"
									placeholder="Nombre y Apellidos"
									name="bank_account[name]"
									form = "checkout_form"
									v-model="store.bankAccount.name">

								<input class="input form-control userEvent__input"
									type="text"
									placeholder="Número de Cuenta"
									name="bank_account[account_number]"
									form = "checkout_form"
									v-model="store.bankAccount.account_number">

								<input class="input form-control userEvent__input"
									type="text"
									placeholder="CLABE"
									name="bank_account[CLABE]"
									form = "checkout_form"
									v-model="store.bankAccount.CLABE">
							</div>
						@else
							<p class="userEvent__paragraph userEvent__columns--paragraph">No tienes ninguna cuenta bancaria registrada.</p>
							@include('users.events.general.banking-form', ['btn_copy' => 'Guardar Cuenta', 'btn_class' => 'black'])
						@endif
						<div class="divisor checkout__divisor"></div>
					</div>

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
						<shopping-bag-for-event-checkout
							:current-bag="store.current_bag"
							:exchange-rate="store.exchange_rate"
							:iva="store.iva"
							:is-shopping-bag="false"
							:balance="store.balance"
							:minimum="store.minimum"
							:fee-percentage="store.fee_percentage"
							:in-zona-metropolitana="inZonaMetropolitana"
							:bag-totals="store.bag_totals"
							:discount-info="store.discount"
						></shopping-bag-for-event-checkout>
					</div>

					@include('client.checkout.partials.submit')

				</div>

			</div>

		</div>

		{{--  Bank Accounts --}}
		<div v-if="is_deposit">
			{{-- Boolenos --}}
			<input type="hidden" name="cash_out_required" form = "checkout_form" value="1">

			{{-- Cuenta nueva o vieja --}}
			<input v-if="store.bankAccount.bank_account_id !== -1 && store.bankAccount.bank_account_id !== 'new_account'  "
				type="hidden" form="checkout_form" name="bank_account_id" v-model="store.bankAccount.bank_account_id">
			<input v-else
				type="hidden" form="checkout_form" name="other_bank_account" value="1">

			{{-- Datos de cuenta nueva --}}
			<input type="hidden" name="bank_account[bank]" form = "checkout_form" v-model="store.bankAccount.bank">
			<input type="hidden" name="bank_account[branch]" form = "checkout_form" v-model="store.bankAccount.branch">
			<input type="hidden" name="bank_account[name]" form = "checkout_form" v-model="store.bankAccount.name">
			<input type="hidden" name="bank_account[account_number]"	form = "checkout_form" v-model="store.bankAccount.account_number">
			<input type="hidden" name="bank_account[CLABE]" form = "checkout_form" v-model="store.bankAccount.CLABE">
		</div>
		{{--  /Bank Accounts --}}

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
		<input type="hidden" form="checkout_form" name="address[references]" v-model="store.shippingAddress.references_code">

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
	    'id'                    => 'discountcodevalidation_form',
	]) !!}

		<input type="hidden" form="discountcodevalidation_form" name="discount_code" v-model="discount_code">

	{!! Form::close() !!}

@endsection

@section('conekta_script')
	<script type="text/javascript" src="https://conektaapi.s3.amazonaws.com/v0.3.2/js/conekta.js"></script>
	<script>
		Conekta.setPublishableKey('{{ env('CONEKTA_PUBLIC_KEY') }}');
	</script>
@endsection

@section('vue_templates')
{{-- Shopping Bag --}}
<script type="x/templates" id="shopping-bag-for-event-checkout-template">
	<div>
		<div>@include('users.events.cart.summary')</div>
		<input type="hidden" name="bag_total" v-model="order_total" form="checkout_form">
		<input type="hidden" name="cash_out_total" v-model="balance_to_be_transfered" form="checkout_form">
		<input type="hidden" name="order_total" v-model="total_to_be_paid" form="checkout_form">
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
		mainVueStore.bag_event = {!! json_encode($personal_event) !!}
		mainVueStore.states_and_mun = {!! json_encode($mexico_states_and_mun) !!}
		mainVueStore.bag_totals = {!! json_encode($bag->bag_totals) !!}
		mainVueStore.is_event_checkout = {!! json_encode($bag->bagType->event) !!}

		mainVueStore.balance = {!! json_encode($personal_event->current_total) !!}
		mainVueStore.minimum = {!! json_encode($personal_event->current_checkout_min) !!}
		mainVueStore.fee_percentage = {!! json_encode($personal_event->current_fee_percentage) !!}

		mainVueStore.discount_codes_types = {!! json_encode($discount_codes_types) !!}
	</script>
@endsection
