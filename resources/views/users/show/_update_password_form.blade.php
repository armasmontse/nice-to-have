{!! Form::open([
    'method'                => 'PATCH',
    'route'                 => ['user::password.update',$user->name],
    'role'                  => 'form' ,
    'id'                    => 'update_password_form',
    'class'                 => 'users__user-container--lg',
]) !!}

    <div class="users__title-container--md">
        <span class="users__text--subtitle">contraseña: </span>
        <span class="users__text--data">**********</span>
    </div>
    <div class="users__input-container">
        {!! Form::password('password', [
            'class'         => 'input',
            'placeholder'   => 'Nueva contraseña',
            'required'      => 'required',
            'form'          => 'update_password_form'
        ]) !!}

        {!! Form::password('password_confirmation', [
            'class'         => 'input',
            'placeholder'   => 'Confirmar nueva contraseña',
            'required'      => 'required',
            'form'          => 'update_password_form'
        ]) !!}

        {!! Form::password('old_password', [
            'class'         => 'input',
            'placeholder'   => 'Contraseña actual',
            'required'      => 'required',
            'form'          => 'update_password_form'
        ]) !!}
    </div>

    <div class="users__submit-container">
        {!! Form::submit('guardar cambios', [
            'class' => 'input__submit',
            'form'  => 'update_password_form'

        ]) !!}
    </div>
    <div class="divisor"></div>

{!!Form::close()!!}
