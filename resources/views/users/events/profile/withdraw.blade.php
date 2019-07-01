
	@if ( $personal_event->is_publish )

		<div class="userEvent__columns--block">

			<p class="userEvent__title">Retiro de Efectivo</p>

			<div class="userEvent__paragraph userEvent__columns--paragraph">
				{!!  $event_profile_cash_withdrawal_copy!!}
			</div>

			<center>
				<a href="{{ route('user::events.cash-outs.index',[$user->name,$personal_event->slug]) }}" class="input__submit userEvent__btn userEvent__columns--btn button">Retiro de Efectivo</a>
			</center>

		</div>

	@endif
