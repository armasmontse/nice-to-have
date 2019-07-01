
	<div class="grid__container userEvent__movimientos">
		<p class="userEvent__title">Movimientos:</p>
	</div>

	<div class="grid__container userEvent--pbottom">
		<table class="userEvent__movimientos--table">
			<thead>
				<tr>
					<th class="userEvent__movimientos--th userEvent__movimientos--fecha">Fecha</th>
					<th class="userEvent__movimientos--th userEvent__movimientos--concepto">Concepto</th>
					<th class="userEvent__movimientos--th userEvent__movimientos--cargo">Cargo</th>
					<th class="userEvent__movimientos--th userEvent__movimientos--abono">Abono</th>
					<th class="userEvent__movimientos--th userEvent__movimientos--saldo">Saldo</th>
				</tr>
			</thead>
			<tbody>
				@foreach ($movements as $movement)
					<tr class="userEvent__movimientos--tr">
						<td class="userEvent__movimientos--td userEvent__movimientos--fecha">
							<span class="userEvent__movimientos--label">Fecha: </span>
							<span class="userEvent__movimientos--content">{{ $movement['date']->format('d/m/y') }}</span>
						</td>
						<td class="userEvent__movimientos--td userEvent__movimientos--concepto">
							<span class="userEvent__movimientos--label">Concepto: </span>
							<span class="userEvent__movimientos--content">{{ $movement['concept'] }}</span>
						</td>
						<td class="userEvent__movimientos--td userEvent__movimientos--cargo">
							<span class="userEvent__movimientos--label">Cargo: </span>
							<span class="userEvent__movimientos--content userEvent--number">
								@if (!$movement['revert'])
									$ {{ number_format($movement['amount'], 2, '.', ',') }}
								@else
									–
								@endif
							</span>
						</td>
						<td class="userEvent__movimientos--td userEvent__movimientos--abono">
							<span class="userEvent__movimientos--label">Abono: </span>
							<span class="userEvent__movimientos--content userEvent--number">
								@if ($movement['revert'])
									$ {{ number_format($movement['amount'], 2, '.', ',') }}
								@else
									–
								@endif
							</span>
						</td>
						<td class="userEvent__movimientos--td userEvent__movimientos--saldo">
							<span class="userEvent__movimientos--label">Saldo: </span>
							<span class="userEvent__movimientos--content userEvent--number">$ {{ number_format($movement['balance'], 2, '.', ',') }}</span>
						</td>
					</tr>
				@endforeach
			</tbody>
		</table>
	</div>
