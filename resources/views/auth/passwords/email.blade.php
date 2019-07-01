@extends('layouts.client', ['user' => true])

@section('content')
    <div class="grid__row email__row">
        <div class="grid__container email__container">
            <div class="grid__col-1-1 grid__col-1-1--sm">
                <div class="grid__box email__box">
                    <div class="email__title-container">
                        <span class="email__title email__title--small">reset password</span>
                    </div>

                    <form role="form" method="POST" action="{{ route('client::pass_reset_email') }}">
                        {{ csrf_field() }}

                        <div class="email__input-container">
                            <input id="email" type="email" class="input" placeholder="Correo electrónico" name="email" value="{{ old('email') }}" required>
                        </div>

                        <div class="email__button-container">
                            <button type="submit" class="input__submit">
                                enviar enlace
                            </button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
@endsection
