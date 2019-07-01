@extends('layouts.client', ['user' => true])


@section('content')
    <div class="grid__row set__row">
        <div class="grid__container set__container">
            <div class="grid__col-1-2 grid__col-1-1--sm">
                <div class="grid__box set__box">
                    <div class="set__title-container">
                        <span class="set__title">Activar cuenta</span>
                    </div>

                    {!! Form::open([
                        'method'             => 'PATCH',
                        'route'              => ['client::pass_set:patch',$encode_email],
                        'role'               => 'form' ,
                        'id'                 => 'set_pasword_form',
                        'class'              => '',
                        ]) !!}

                        <div class="set__input-container">
                            {!! Form::password('password', [
                                'class' => 'input',
                                'required' => 'required',
                                'placeholder' => 'Contraseña'
                                ]) !!}

                                {!! Form::password('password_confirmation', [
                                    'class' => 'input',
                                    'required' => 'required',
                                    'placeholder' => 'Confirmar Contraseña'
                                    ]) !!}
                        </div>

                        <div class="set__links-container">
                            <a class="login__link" href="{{ route('client::login:get') }}">Regresar - Iniciar Sesión</a>

                            <button type="submit" class="input__submit">
                                enviar contraseña
                            </button>
                        </div>


                    {!! Form::close() !!}
                </div>
            </div>
        </div>
    </div>
@endsection
