
	<div class="grid__container userEvent--ptop userEvent__resumen">
		<p class="userEvent__title">Resumen de cuentas:</p>
	</div>

	<div class="grid__container userEvent__columns">
		<div class="grid__col-1-2 userEvent__col-1-2">
			<div class="userEvent__box">
				<div class="flex-cont--sb mb2m">
					<div>
						<p class="userEvent__title tal">Total de regalos recibidos:</p>
						<p class="userEvent__paragraph tal">Total en pesos de los productos <br>regalados (incluyendo IVA).</p>
					</div>
					<p class="userEvent--number userEvent__title--no-wrap">$ {{ number_format($personal_event->current_protected_bag_value, 2, '.', ',') }}</p>
				</div>
				<div class="flex-cont--sb mb2m">
					<div>
						<p class="userEvent__title tal">Mínimo en productos:</p>
						<p class="userEvent__paragraph tal">Cantidad mínima para realizar <br>pedido de productos NICE TO HAVE. <br>Incluye envíos en área metropolitana.</p>
					</div>
					<p class="userEvent--number tal userEvent__title--no-wrap">$ {{ number_format($personal_event->current_checkout_min, 2, '.', ',') }}</p>
				</div>
				<div class="flex-cont--sb mb2m">
					<div>
						<p class="userEvent__title tal">Máximo en efectivo:</p>
						<p class="userEvent__paragraph tal">Cantidad máxima de efectivo, {{ $percentage }}%<br>de los regalos.
					</div>
					<p class="userEvent--number tal userEvent__title--no-wrap">$ {{ number_format($personal_event->current_cashouts_max, 2, '.', ',') }}</p>
				</div>
			</div>
		</div>

		<div class="grid__col-1-2 userEvent__col-1-2">
			<div class="userEvent__box">
				<div class="flex-cont--sb mb2m">
					<div>
						<p class="userEvent__title tal">Saldo:</p>
						<p class="userEvent__paragraph tal">Saldo de regalos recibidos al <br>momento menos retiros.
					</div>
					<p class="userEvent--number userEvent__title--no-wrap">$ {{ number_format($personal_event->current_total, 2, '.', ',') }}</p>
				</div>
			</div>
		</div>
	</div>
