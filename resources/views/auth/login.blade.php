@extends('layouts.client')

@section('content')
    <div class="grid__row login__row create-event__row" style="@if(isset($background_url)) background-image: url('{{ $background_url }}'); @endif">
        <div class="grid__container login__container">
            <div class="grid__col-1-1 grid__col-1-1--sm">
                <div class="grid__box login__box">
                    <div class="login__title-container">
                        <span class="login__title login__title--small">inicia sesión</span>
                        <div class="wysiwyg">
                            <p class="checkout__login-p login__wysiwyg">
                                {!! $show_empty_copy ? (!$login_copy ? trans('general.no_description') : $login_copy) : $login_copy !!}
                                {{-- Para garantizar que tu compra sea segura y poder agregarla a tu historial, es importante que inicies sesión. Si aún no estás registrado, haz click en nuevo usuario. --}}
                            </p>
                        </div>
                    </div>

                    <form role="form" method="POST" action="{{ route('client::login:post') }}">
                        {{ csrf_field() }}

                        <div class="login__input-container">
                            <input id="email" type="email" class="input" placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required autofocus>
                            <input id="password" type="password" class="input" placeholder="Contraseña" name="password" required>
                        </div>

                        <div class="login__button-container">
                            <button type="submit" class="input__submit" name="button">Entrar</button>
                        </div>

                        <div class="login__button-container">
                            <a href="{{ route('client::login.facebook')}}" class="input__submit">Entrar con Facebook</a>
                            {{-- <button type="button" class="input__submit" name="button">facebook</button> --}}
                        </div>

                        <div class="login__links-container">
                            <a class="login__link" href="{{ route('client::pass_reset:get') }}">
                                Olvidé la contraseña
                            </a>
                            <a class="login__link" href="{{ route('client::register:get') }}">
                                Nuevo usuario - Registro
                            </a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
