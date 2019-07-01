
	<div class="grid__col-1-2 checkout__col-1-2">
		<div class="checkout__box checkout__box-right">

			<div class="userEvent__columns--block">

				<p class="userEvent__title">Solicitud de Retiro</p>
				<div class="userEvent__paragraph userEvent__columns--paragraph">
					@if ($personal_event->is_publish && $personal_event->not_canceled_cash_outs->isEmpty())
						{!! $cash_withdrawal_instructions_copy !!}
					@else 
						{!! $cash_withdrawal_withdrawal_requested_copy !!}
					@endif
					<br><br>
				</div>

				@if ($personal_event->is_publish && $personal_event->not_canceled_cash_outs->isEmpty())
					<div class="users__bank-account-container">
						
						@if ($user->bank_accounts->count() > 0)
							{!! Form::open([
								'method'        => "POST",
								'route'         => ["user::events.cash-outs.store",$user->name, $personal_event->slug],
								'role'          => 'form' ,
								'id'			=> 'create_cashout_form',
								'v-on:change'	=> 'toggleForms()'

							]) !!}
								@foreach ($user->bank_accounts as $bank_account)

									<span class="userEvent__input--row">
										{!! Form::radio('bank_account_id',$bank_account->id,null, [
											'class'		=> 'input__radio',
											'id'		=> 'bank_account-'.$bank_account->id,
											'form'		=> 'create_cashout_form',
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
								<span class="userEvent__input--row">
									{!! Form::radio('bank_account_id','',null, [
										'class'		=> 'input__radio',
										'id'		=> 'bank_account-0',
									]) !!}
									<label for="bank_account-0" class="userEvent__paragraph">
										<span class="users__text--data users__text--data-bank">Agregar nueva cuenta</span>
									</label>
								</span>
								<div id="request_withdraw_JS">
									<input class="input form-control userEvent__input"
										type="number"
										step="0.01"
										min="{{ number_format($cashout_min_amount,2,".","") }}"
										max="{{ number_format($personal_event->current_cashouts_max,2,".","") }}"
										placeholder="Cantidad a Retirar"
										name="amount"
										required="required"
										form='create_cashout_form'>
									<input type="submit"
									 	form="create_cashout_form"
										class="input__submit black userEvent__btn userEvent__columns--btn"
										value="Solicitar depósito de efectivo">
								</div>
							{!!Form::close()!!}
							<div id="add_account_JS" class="userEvent__add-account">
								@include('users.events.general.banking-form', ['btn_copy' => 'Guardar Cuenta', 'btn_class' => 'black'])
							</div>
						@else
							<p class="userEvent__paragraph userEvent__columns--paragraph">No tienes ninguna cuenta bancaria registrada.</p>
							@include('users.events.general.banking-form', ['btn_copy' => 'Guardar Cuenta', 'btn_class' => 'black'])
						@endif

					</div>
				@endif

				<br><br><br>

			</div>

		</div>
	</div>
