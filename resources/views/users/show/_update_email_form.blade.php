{!! Form::open([
    'method'                => 'PATCH',
    'route'                 => ['user::email.update',$user->name],
    'role'                  => 'form' ,
    'id'                    => 'update_email_form',
    'class'                 => 'users__user-container--lg',
]) !!}

    <div class="users__title-container--md">
        <span class="users__text--subtitle">correo electrónico: </span>
        <span class="users__text--data">{{ $user->email }}</span>
    </div>
    <div class="users__input-container">
        {!! Form::email('email', null, [
            'class'         => 'input',
            'placeholder'   => 'Nuevo correo electrónico',
            'required'      => 'required',
            'form'          => 'update_email_form'
        ]) !!}
        {!! Form::password('password', [
            'class'         => 'input',
            'placeholder'   => 'Contraseña',
            'required'      => 'required',
            'form'          => 'update_email_form'
        ]) !!}
    </div>
    <div class="users__submit-container">
        {!! Form::submit('guardar cambios', [
            'class' => 'input__submit',
            'form'  => 'update_email_form'

        ]) !!}
    </div>
    <div class="divisor"></div>

{!!Form::close()!!}
