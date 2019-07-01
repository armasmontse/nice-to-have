<div class="users__user-container--lg">
    <div class="users__title-container--md">
        <span class="users__text--subtitle">formas de pago:</span>
    </div>

    @forelse ($user->cards as $card)
        {!! Form::open([
            'method'                => 'DELETE',
            'route'                 => ['user::cards.destroy',$user->name,$card->id ],
            'role'                  => 'form' ,
            'id'                    => 'delete_card-'.$card->id.'_form',
            'class'                 => 'users__payment-child-container',
        ]) !!}

            <span class="users__text--data users__text--data-block">{{ $card->display_number }}</span>
            {!! Form::submit('eliminar esta tarjeta', [
                'class' => 'input__submit users__button--sm',
                'form'  => 'delete_card-'.$card->id.'_form',
            ]) !!}

        {!!Form::close()!!}

    @empty
        <div class="users__payment-child-container">
            <span class="users__text--data users__text--data-block">Sin formas de pago</span>
        </div>
    @endforelse
    <div class="divisor"></div>
</div>
