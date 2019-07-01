@extends('layouts.client')

@section('content')

    @if (is_page("client::bag.checkout.register"))
    	{{-- barra superior con titulo y pasos --}}
    	<div class="grid__row">
    		<div class="grid__container--full-width users__container-page-title">
    			<div class="grid__col-1-1">
    				<div class="grid__box">
    					@include('client.general.page-title', ['title' => 'COMPRA']){{-- muahahahaha --}}
    				</div>
    			</div>


    		{{-- Pasos --}}
    			<div class="grid__container">
    				<div class="grid__col-1-1">
    						<div class="	shopping-cart__link-menu-container
    										checkout__link-menu-container"
    						>
    							<span class="shopping-cart__link-menu selected">
    								1. Registro
    							</span>
    							<span class='icon__caret-right'>{!! file_get_contents('images/icon-caret-right.svg') !!}</span>
    							<span class="shopping-cart__link-menu">
    								2. Envio
    							</span>
    							<span class='icon__caret-right'>{!! file_get_contents('images/icon-caret-right.svg') !!}</span>
    							<span class="shopping-cart__link-menu">
    								3. Pago
    							</span>
    						</div>
    						<div class="divisor"></div>
    					</div>
    			</div>
    		</div>
    	</div>
    @endif
    <div class="grid__row register__row"  @if ($background_url) style="background-image: url('{{ $background_url }}')" @endif >
        <div class="grid__container register__container">
            <div class="grid__col-1-1 grid__col-1-1--sm">
                <div class="grid__box register__box  {{ is_page("client::bag.checkout.register") ? 'login__box--register' : ''}}">
                    <div class="register__title-container">
                        <span class="register__title register__title--small">regístrate</span>
                        @if (is_page("client::register:get"))
                            <div class="wysiwyg checkout__login-p register__wysiwyg">
                                {!! $show_empty_copy ? (!$register_copy ? trans('general.no_description') : $register_copy) : $register_copy !!}
                            </div>
                        @endif
                    </div>
                    @unless (is_page("client::register:get"))
                        <div class="wysiwyg checkout__login-p register__wysiwyg">
                            {!! $show_empty_copy ? (!$register_copy ? trans('general.no_description') : $register_copy) : $register_copy !!}
                        </div>
                    @endunless

                    @if (is_page("client::event.register"))
                        <div class="register__title-container">
                            <span class="create-event__step create-event__step--small">Paso de 1 de 5</span>
                        </div>
                    @endif

                    <form role="form" method="POST" action="{{ route('client::register:post') }}">
                        {{ csrf_field() }}
                        <div class="register__input-container">
                            <input id="first_name" type="text" class="input" placeholder="Nombre" name="first_name" value="{{ old('first_name') }}" required autofocus>
                            <input id="last_name" type="text" class="input" placeholder="Apellido" name="last_name" value="{{ old('last_name') }}" required autofocus>
                            <input id="email" type="email" class="input" placeholder="Correo Electrónico" name="email" value="{{ old('email') }}" required>
                            <input id="password" type="password" class="input" placeholder="Contraseña" name="password" required>
                            <input id="password-confirm" type="password" class="input" placeholder="Confirmar contraseña" name="password_confirmation" required>
                        </div>

                        <p class="register--copy">*Tus datos no serán utilizados con ningún otro fin.</p>

                        <div class="register__button-container">
                            <button type="submit" class="input__submit">
                                Crear cuenta
                            </button>
                        </div>

                        <div class="register__button-container">
                            {{-- <button type="button" class="input__submit">
                                crear cuenta facabook
                            </button> --}}
                            <a href="{{ route('client::login.facebook')}}" class="input__submit">Crear cuenta con Facebook</a>
                        </div>

                        <center>
                            <a class="register__link" href="{{ route('client::login:get') }}" style="text-decoration:none;">
                                ¿Ya estás registrado? <span style="text-decoration:underline;">Iniciar sesión</span>
                            </a>
                        </center>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
