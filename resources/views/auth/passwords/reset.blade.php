@extends('layouts.client', ['user' => true])

@section('content')
    <div class="grid__row reset__row">
        <div class="grid__container reset__container">
            <div class="grid__col-1-1 grid__col-1-1--sm">
                <div class="grid__box reset__box">
                    <div class="reset__title-container">
                        <span class="reset__title reset__title--small">restablecer contraseña</span>
                    </div>

                    <form role="form" method="POST" action="{{ route('client::pass_reset:post') }}">
                        {{ csrf_field() }}

                        <div class="reset__input-container">
                            <input type="hidden" name="token" value="{{ $token }}">
                            <input id="email" type="email" class="input" placeholder="Correo electrónico" name="email" value="{{ $email or old('email') }}" required autofocus>
                            <input id="password" type="password" class="input" placeholder="Contraseña" name="password" required>
                            <input id="password-confirm" type="password" class="input" placeholder="Confirmar Contraseña" name="password_confirmation" required>

                        </div>

                        <div class="reset__button-container">
                            <button type="submit" class="input__submit">
                                restablecer contraseña
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
