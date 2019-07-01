
	<div class="grid__col-1-2 checkout__col-1-2">
		<div class="checkout__box checkout__box-left">
			<div>
				<div class="userEvent__blue-container">
					<p class="userEvent__title mb0">Disponible en Efectivo</p>
					<p class="userEvent__title">$ {{ number_format($personal_event->current_cashouts_max,2,".",",") }} MXN</p>
				</div>

				<div class="userEvent__paragraph-container">
					<div class="userEvent__paragraph">
                        {!! $cash_withdrawal_fees_copy !!}
                    </div>
				</div>

				<div class="divisor userEvent__divisor"></div>
				
				{{-- dump($personal_event->not_canceled_cash_outs->first()) --}}

				<p class="userEvent__title">Retiro:</p>
				<div class="userEvent__paragraph-container">
					<div class="flex-cont--sb">
						<p class="userEvent__title">Fecha de Solicitud</p>
						<p class="userEvent--number">{{ $cashout_date }}</p>
					</div>
					<div class="flex-cont--sb">
						<p class="userEvent__title">Retiro de efectivo</p>
						<p class="userEvent--number">$ {{ $cashout_amount }} MXN</p>
					</div>
					<div class="flex-cont--sb">
						<p class="userEvent__title">Comisión de retiro</p>
						<p class="userEvent--number">- $ {{ $cashout_fee }} MXN</p>
					</div>
					<div class="flex-cont--sb">
						<p class="userEvent__title">Total de transferencia</p>
						<p class="userEvent--number">$ {{ $cashout_transfer }} MXN</p>
					</div>

					<div class="flex-cont--sb">
						<p class="userEvent__title">Estatus de transferencia</p>
						<p class="userEvent--number">{{ $cashout_status }}</p>
					</div>
				</div>
			</div>
		</div>
	</div>
