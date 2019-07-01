@extends('layouts.client', ['user' => true])

@section('content')
    <div class="grid__row login__row">
        <div class="grid__container login__container">
            <div class="grid__col-1-1 grid__col-1-1--sm">
                <div class="grid__box login__box">
                    <div class="login__title-container">
                        <span class="login__title">Ingresar</span><br><br>
                        <small class="shopping-cart__text" style="line-height: 24px;font-size: 10px;">Ingresa el email con el que registraron tus regalos.</small>
                    </div>

                    <form role="form" method="POST" action="{{ route('client::presents.auth', ['present_bag' => $present_bag->key] ) }}">

                        {{ csrf_field() }}

                        <div class="login__input-container">
                            <input id="email" type="email" class="input" placeholder="Correo electrónico" name="email" value="" required autofocus>
                        </div>

                        <div class="login__button-container">
                            <button type="submit" class="input__submit">Entrar</button>
                        </div>

                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
