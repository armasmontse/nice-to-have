
	<div class="userEvent__blue-container" :class="{'userEvent__blue-container--red' : !is_over_minimum}">
		<p class="userEvent__title mb0">Total mínimo para realizar pedido ( {{ number_format($checkout_min_percentage ,0) }}%)</p>
		<p class="userEvent__title">$ {{ number_format($personal_event->current_checkout_min,2,".",",") }} MXN</p>
	</div>
	<p class="userEvent__title mb3m" v-if="total_items_in_bag > 1">(@{{total_items_in_bag}}) Artículos en tu carrito</p>
	<p class="userEvent__title mb3m" v-else>(1) Artículo en tu carrito</p>

	<div class="userEvent__paragraph-container">

		<div class="userEvent__columns--block">
			<div class="flex-cont--sb">
				<p class="userEvent__title">Subtotal</p>
				<p class="userEvent--number">@{{subtotal | parseMoney}}</p>
			</div>
			<div class="flex-cont--sb">
				<p class="userEvent__title">I.V.A.</p>
				<p class="userEvent--number">@{{iva_price | parseMoney}}</p>
			</div>
			<div class="flex-cont--sb">
				<p class="userEvent__title">Costo de envío</p>
				<p class="userEvent--number">@{{shipping_costs | parseMoney}}</p>
			</div>

			<div v-if="discountInfo && discountInfo.type" class="flex-cont--sb">
			    <span class="userEvent__title">Código de descuento:</span>
			    <span class="userEvent--number">@{{ discount | parseMoney }}</span>
			</div>

			<div class="flex-cont--sb">
				<p class="userEvent__title">Total</p>
				<p class="userEvent--number">@{{order_total | parseMoney}}</p>
			</div>
		</div>

		<div class="userEvent__columns--block">
			<div class="flex-cont--sb">
				<p class="userEvent__title">Saldo Mesa de Regalos</p>
				<p class="userEvent--number">@{{balance | parseMoney}}</p>
			</div>
			<div class="flex-cont--sb">
				<p class="userEvent__title">Total a pagar</p>
				<p class="userEvent--number">@{{total_to_be_paid | parseMoney}}</p>
			</div>
		</div>

		<div class="userEvent__columns--block" :style="{display: balance_to_be_transfered > 0 ? 'block' : 'none'}">
			{{-- IMPORTANTE: se usa ":style" para controlar el display en lugar de "v-if" porque por alguna bizarra razón, en este caso, el componente deja de correr el método "notifyParentOnTransferTotalChange" cuando el v-if desaparece esta parte del template . Posiblemente se deba a  dos razones: 1) que Vue 1.0.x no está diseñado para que las propiedades computadas sean watcheadas, lo que me obligó a correr un método dentro de ellas. 2) Como las propiedades computadas en esta versión del framework parecen tener el objetivo de ser usadas en los templates, entonces al no parecer en un template, la función que las calcula deja de ser ejecutada (interesantemente, cuando el as devTools entraba a ver el objeto éste las calculaba inmediatamente, pero seguía sin ejecutar correctamente el método).--}}
			<div class="flex-cont--sb">
				<p class="userEvent__title">Saldo depósito final</p>
				<p class="userEvent--number">@{{balance_to_be_transfered | parseMoney}}</p>
			</div>
			<div class="flex-cont--sb">
				<p class="userEvent__title">Comisión de depósito</p>
				<p class="userEvent--number">@{{transfer_fee | parseMoney}}</p>
			</div>
			<div class="flex-cont--sb">
				<p class="userEvent__title">Total de transferencia</p>
				<p class="userEvent--number">@{{transfer_total | parseMoney}}</p>
			</div>
		</div>

		<div v-if="isShoppingBag">
			{{-- Proceder a compra --}}
			<div v-if="!closeEmptyBag === true"
				class="shopping-cart__link-container shopping-cart__link-container--compra">
				<a v-if="is_over_minimum" href="{{route('user::events.bag.checkout:get', [$user->name, $personal_event->slug])}}" class="input__submit single__submit">Proceder a compra</a>
				<div v-else>
					<div class="userEvent__paragraph userEvent__paragraph--under-minimum-notice">
						{!! $event_checkout_alert_not_min_copy !!}
					</div>

					<a href="{{ route('client::shop.index') }}" class="input__submit checkout__link-button checkout__link--lg">
						ir a tienda
					</a>
				</div>
			</div>

			{{-- Cerrar carrito si esta vacio --}}
			<div v-else class="tac">
				<p class="userEvent__paragraph mb1m">Tu carrito está en ceros, ¿deseas cerrarlo?</p>
					<div class="shopping-cart__link-container shopping-cart__link-container--compra mb1m">
						<span class="input__submit" v-on:click="close_empty_bag_modal_is_open = true">Cerrar Carrito</span>
					</div>
			</div>

			<div class="shopping-cart__link-container">
				<a href="{{route('client::shop.index')}}" class="shopping-cart__link">Continuar comprando</a>
			</div>
		</div>

	</div>

{{-- Modal Cerrar Bag Vacía --}}
	<div v-if="close_empty_bag_modal_is_open" @click.stop="close_empty_bag_modal_is_open = false" class="modal__overlay">
		<div class="modal__container" @click.stop="">
			<span class="modal__close" @click="close_empty_bag_modal_is_open = false">{!! file_get_contents('images/icon-close.svg') !!}</span>
			<div class="modal__container-scrollable">

				{!! Form::open([
						'method'                => 'post',
						'route'                 => ['user::events.bag.checkout:post', $user->name, $personal_event->slug],
						'role'                  => 'form' ,
						'id'                    => 'checkout_form',
						'v-on.submit.prevent"'  => 'post'
					]) !!}
					<div class="modal__message">
							<div class="userEvent__paragraph">
								{!! $event_bags_popup_close_empty_bag_copy !!}
							</div>
							{{-- checkbox de Accept Terms --}}
							<div class="shopping-cart__link-container shopping-cart__link-container--compra mb1m">
									{{-- Submit --}}
									{{-- <input v-if="accept_terms" type="submit" class="input__submit" value="Cerrar Carrito"> --}}
							</div>
							{{-- <div class="checkout__checkbox-container"> --}}
							<div class="mb1m">
									<input type="text" class="input" form="checkout_form" id="first_name" name="first_name" placeholder="Nombre" value="{{$user->first_name}}">
									<input type="text" class="input" form="checkout_form" id="last_name" name="last_name" placeholder="Apellido" value="{{$user->last_name}}">
									<input type="text" class="input" form="checkout_form" id="phone" name="phone" placeholder="Teléfono" value="{{$user->phone}}">
									{{-- <input type="hidden" class="input" form="checkout_form" id="order_total" name="order_total" v-model="order_total" >
									<input type="hidden" name="cash_out_total" form = "checkout_form" v-model="cash_out_total"> --}}
									<input type="hidden" name="bag_total" v-model="order_total" form="checkout_form">
									<input type="hidden" name="cash_out_total" v-model="balance_to_be_transfered" form="checkout_form">
									<input type="hidden" name="order_total" v-model="total_to_be_paid" form="checkout_form">

							</div>
							<div class="mb1m">
							        <label for="accept_terms" class="input__checkbox-label checkout__checkbox-label">
							            {!! Form::checkbox('accept_terms', true, null, [
							                'class'     => 'input__checkbox',
							                'required'  => 'required',
							                'form'      => 'checkout_form',
							                'id'        => 'accept_terms',
							                'v-model'   => 'accept_terms'
							            ]) !!}
								           Acepto los <a class="checkout__link checkout__link-grey m0 inline" href="{{route("client::pages.show","terminos-y-condiciones") }}" target="_blank" >Términos y condiciones</a>
							        </label>
							</div>
					</div>

					<div class="modal__actions-container modal__actions-container--no-db">
						<span class="input__submit" @click="close_empty_bag_modal_is_open = false">No cerrar</span>
						<input v-if="accept_terms" type="submit" class="input__submit inline-block" value="Cerrar Carrito">
						<span v-else class="input__submit" disabled>Cerrar carrito</span>
					</div>
				{!! Form::close() !!}
			</div>
		</div>
	</div>
