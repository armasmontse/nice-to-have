<div class="users__user-container--lg">
    <div class="users__title-container--md">
        <span class="users__text--subtitle">Cuentas bancarias:</span>
    </div>

    @forelse ($user->bank_accounts as $bank_account)
        {!! Form::open([
            'method'                => 'DELETE',
            'route'                 => ['user::bank_accounts.destroy',$user->name,$bank_account->id ],
            'role'                  => 'form' ,
            'id'                    => 'delete_bank_account-'.$bank_account->id.'_form',
            'class'                 => 'users__bank-account-container'
        ]) !!}

            <div class="users__user-container users__user-container--lg" style="width: 100%;">
                <div class="users__general-info-container">
                    <span class="users__text--data users__text--data-bank">NOMBRE: {{ $bank_account->name }}</span>
                    <span class="users__text--data users__text--data-bank">BANCO: {{ $bank_account->bank }}</span>
                    <span class="users__text--data users__text--data-bank">SURCURSAL: {{ $bank_account->branch }}</span>
                    <span class="users__text--data users__text--data-bank">CUENTA: {{ $bank_account->account_number }}</span>
                    <span class="users__text--data users__text--data-bank">CLABE: {{ $bank_account->displayCLABE() }}</span>
                </div>
				@if ($user->bank_accounts->count() > 1)
					{!! Form::submit('Eliminar esta cuenta', [
						'class' => 'input__submit users__button--bank',
						'form'  => 'delete_bank_account-'.$bank_account->id.'_form',
					]) !!}
				@endif

            </div>

        {!!Form::close()!!}

    @empty
        <div class="users__payment-child-container">
            <p class="users__text--data users__text--data-block">
                Ninguna cuenta bancaria registrada.
                <br><br><br>
            </p>
        </div>
    @endforelse

    <div class="divisor"></div>

</div>
