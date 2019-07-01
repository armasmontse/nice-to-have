<div class="userEvent__columns--block">

	<p class="userEvent__title">Datos bancarios para depósito de retiros</p>

	@if ($user->bank_accounts->count() > 0)
		@foreach ($user->bank_accounts as $bank_account)
			{!! Form::open([
				'method'		=> 'DELETE',
				'route'			=> ['user::bank_accounts.destroy',$user->name,$bank_account->id ],
				'role'			=> 'form' ,
				'id'			=> 'delete_bank_account-'.$bank_account->id.'_form',
				'class'			=> 'users__bank-account-container'
			]) !!}

				<div class="users__user-container" style="width: 100%;">
					<div class="users__general-info-container">
						<span class="users__text--data users__text--data-bank">NOMBRE: {{ $bank_account->name }}</span>
						<span class="users__text--data users__text--data-bank">BANCO: {{ $bank_account->bank }}</span>
						<span class="users__text--data users__text--data-bank">SURCURSAL: {{ $bank_account->branch }}</span>
						<span class="users__text--data users__text--data-bank">CUENTA: {{ $bank_account->account_number }}</span>
						<span class="users__text--data users__text--data-bank">CLABE: {{ $bank_account->displayCLABE() }}</span>
					</div>
				</div>

			{!!Form::close()!!}
		@endforeach
	@else
		<p class="userEvent__paragraph userEvent__columns--paragraph">No tienes ninguna cuenta bancaria registrada.</p>
		@include('users.events.general.banking-form', ['btn_copy'	=> 	'Guardar Cuenta'])
	@endif

</div>
