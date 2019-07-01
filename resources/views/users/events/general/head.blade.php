
	<div class="grid__container userEvent__meta">

		<div class="grid__col-1-3 userEvent__col userEvent__status">
			<div class="userEvent__paragraph">
			Status de Evento: <span class="userEvent__title">{{ $personal_event->eventStatus->label }}</span>
			</div>
			@if ( $personal_event->is_publish )
				<a href="{{ route('user::events.profile',[$user->name,$personal_event->slug]) }}#activate_event" class="input__submit userEvent__btn button black">Cerrar Evento</a>
			@elseif ( $personal_event->is_draft )
				<a href="{{ route('user::events.profile',[$user->name,$personal_event->slug]) }}#cancel_event" class="input__submit userEvent__btn button black">Activar Evento</a>
			@endif
		</div>

		<div class="grid__col-1-3 userEvent__col userEvent__info">
			<span class="userEvent__paragraph-italic userEvent__info--names">{{ $personal_event->feted_names }}</span>
			<span class="userEvent__paragraph-italic">No: <span class="userEvent__info--key">{{ $personal_event->key }}</span></span>
			<span class="userEvent--line userEvent__info--limit">Fecha límite para escoger regalos: {{ $personal_event->expiration_date->format('d/m/y') }}</span>
			<span class="userEvent--line userEvent__info--min">Mínimo para realizar pedido: ${{ number_format($personal_event->current_checkout_min, 2, '.', ',') }}</span>
			<span class="userEvent--line userEvent__info--max">Máximo disponible en efectivo: ${{ number_format($personal_event->current_cashouts_max, 2, '.', ',') }}</span>
			<span class="userEvent--line userEvent__info--balance">Saldo actual: ${{ number_format($personal_event->current_total, 2, '.', ',') }}</span>
		</div>

		<div class="grid__col-1-3 userEvent__col userEvent__web">
			<div class="userEvent__paragraph">
				Web de Evento:
				<span class="userEvent__title">
					@if ($personal_event->template_is_publish)
						Publicada
					@else
						No Publicada
					@endif
				</span>
			</div>
			@if (!$personal_event->is_publish && !$personal_event->template_is_publish )
				<a href="{{ route('user::events.template.index',[$user->name,$personal_event->slug]) }}" class="input__submit userEvent__btn button black">Personalizar página web</a>
			@elseif($personal_event->is_publish && !$personal_event->template_is_publish)
				<a href="{{ route('user::events.template.index',[$user->name,$personal_event->slug]) }}#publish_template" class="input__submit userEvent__btn button black">Publicar Web de Evento</a>
			@endif
		</div>

	</div>

	<div class="grid__container userEvent__nav">
		@if ($personal_event->is_draft)
			<a class="userEvent__nav--item {{ is_page('user::events.profile') ? 'current' : '' }} " href="{{ route('user::events.profile',[$user->name,$personal_event->slug]) }}">Perfil de Evento</a>
			<a class="userEvent__nav--item {{ is_page('user::events.template.index') ? 'current' : '' }} " href="{{ route('user::events.template.index',[$user->name,$personal_event->slug]) }}">Web de Evento</a>
		@elseif ($personal_event->is_publish)
			<a class="userEvent__nav--item {{ is_page('user::events.profile') ? 'current' : '' }} " href="{{ route('user::events.profile',[$user->name,$personal_event->slug]) }}">Perfil de Evento</a>
			<a class="userEvent__nav--item {{ is_page('user::events.template.index') ? 'current' : '' }} " href="{{ route('user::events.template.index',[$user->name,$personal_event->slug]) }}">Web de Evento</a>
			<a class="userEvent__nav--item {{ is_page('user::events.gifts') ? 'current' : '' }} " href="{{ route('user::events.gifts',[$user->name,$personal_event->slug]) }}">Mensajes y Regalos</a>
			<a class="userEvent__nav--item {{ is_page('user::events.cash-outs.index') ? 'current' : '' }} " href="{{ route('user::events.cash-outs.index',[$user->name,$personal_event->slug]) }}">Retirar Efectivo</a>
			<a class="userEvent__nav--item {{ is_page('user::events.account') ? 'current' : '' }} " href="{{ route('user::events.account',[$user->name,$personal_event->slug]) }}">Estado de Cuenta</a>
		@elseif ($personal_event->is_finish)
			<a class="userEvent__nav--item {{ is_page('user::events.template.index') ? 'current' : '' }} " href="{{ route('user::events.template.index',[$user->name,$personal_event->slug]) }}">Web de Evento</a>
			<a class="userEvent__nav--item {{ is_page('user::events.gifts') ? 'current' : '' }} " href="{{ route('user::events.gifts',[$user->name,$personal_event->slug]) }}">Mensajes y Regalos</a>
			@if ($personal_event->is_close_bag_active)
				<a class="userEvent__nav--item {{ is_page('user::events.bag.index') ? 'current' : '' }} " href="{{ route('user::events.bag.index',[$user->name,$personal_event->slug]) }}">Carrito</a>
			@endif
			<a class="userEvent__nav--item {{ is_page('user::events.account') ? 'current' : '' }} " href="{{ route('user::events.account',[$user->name,$personal_event->slug]) }}">Estado de Cuenta</a>
		@endif
	</div>

	@if (!is_page('user::events.account'))
	<div class="grid__container userEvent__intro">
		<div class="userEvent__paragraph">
			@if (is_page('user::events.profile'))
				{!! $event_profile_header_copy !!}
			@elseif (is_page('user::events.template.index'))
				{!! $web_event_header_copy !!}
			@elseif (is_page('user::events.gifts'))
				{!! $message_and_gifts_gift_registry_copy !!}
			@elseif (is_page('user::events.cash-outs.index'))
				{!! $cash_withdrawal_header_copy !!}
			@elseif (is_page('user::events.bag.index'))
				{!! $event_bags_header_copy !!}
			@endif
		</div>
	</div>
	@endif
