@extends('layouts.client')

@section('title')
    | Perfil
@endsection

@section('content')
    <div class="grid__row">
        <div class="grid__container--full-width users__container-page-title">
            <div class="grid__col-1-1">
                <div class="grid__box">
                    @include('client.general.page-title', ['title' => 'perfil'])
                </div>
            </div>
        </div>

        <div class="grid__container">
            <div class="grid__col-1-2 users__col-1-2">
                <div class="grid__box users__box users__box-left">
                    <div class="users__user-container--lg">
                        <div class="users__title-container--lg">
                            <h2 class="users__text">{{ $user->first_name }} {{ $user->last_name }}</h2>
                        </div>
                        <div class="users__submit-container">
                            <a href="{{route("user::wishlist.index",$user->name) }}" class="input__submit users__submit-btn">IR A FAVORITOS</a>
                            <a href="{{route("client::bags.index")}}" class="input__submit users__submit-btn">VER CARRITO</a>
                        </div>
                        <div class="divisor"></div>
                    </div>

                    @include('users.show._update_email_form')

                    @include('users.show._update_password_form')

                    @include('users.show._cards')

                    @include('users.show._bank_accounts')

                </div>
            </div>

            <div class="grid__col-1-2 users__col-1-2">
                <div class="grid__box users__box-right">
                    <div class="users__title-container--lg">
                        <h2 class="users__text">mis eventos</h2>
                    </div>
                    <div class="grid__container--full-width users__container">

                        @foreach ($user->events as $user_event)
                            <div class="grid__col-1-2 users__col-1-2-nested">
                                <div class="grid__box">
                                    <div class="users__user-container">
                                        <div class="users__event-name-container">
                                            <span class="users__text--data users__text--data-block-hira">{{ $user_event->name}}</span>
                                        </div>

                                        <div class="users__general-info-container">
                                            <span class="users__text--data users__text--data-block-hira">{{ $user_event->date->format("d/m/Y")}} </span>
                                            <span class="users__text--data users__text--data-block-hira">No: <span style="text-transform: uppercase;">{{$user_event->key}}</span></span>
                                            <span class="users__text--data users__text--data-block-hira">Tipo de evento: {{  $user_event->type_label}}</span>
                                        </div>

                                        <div class="users__status-container">
                                            <span class="users__text--data users__text--data-status">{{ $user_event->eventStatus->label }}</span>
                                        </div>

                                        <div class="users__link-container">
                                            <a href="{{ $user_event->perfil_url }}" class="users__link">Ir al evento</a>
                                        </div>

                                        <div class="divisor"></div>
                                    </div>
                                </div>
                            </div>
                        @endforeach

                        <div class="grid__col-1-2 users__col-1-2-nested">
                            <div class="grid__box">
                                <div class="users__user-container">
                                    <div class="users__submit-container users__submit-container--lg">
                                        <a href="{{ route("client::event.register") }}" class ='input__submit users__button'>
											crear evento
                                            {{-- <span class="users__button-create">crear evento</span> --}}
                                            {{-- <span class="users__button-coming-soon">próximamente</span> Temporal: quitar cuando puedan crear eventos --}}
                                        </a>
                                    </div>
                                    <div class="divisor"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="users__title-container--lg">
                        <h2 class="users__text">historial de compras</h2>
                    </div>

                    @if ($user->in_active_bags->isEmpty())
                        <div class="users__title-container--lg users__title-container--lg-center">
                            <span class="users__text--subtitle">Sin compras realizadas</span>
                        </div>
                    @else
                        <div class="grid__container--full-width users__container">
                            @foreach ($user->in_active_bags as $bag)
                                <div class="grid__col-1-2 users__col-1-2-nested">
                                    <div class="grid__box">
                                        <div class="users__user-container">
                                            <div class="users__general-info-container">
                                                <span class="users__text--data users__text--data-block-hira">{{ ($bag->purshased_at ? $bag->purshased_at->format("d/m/Y") : $bag->updated_at->format("d/m/Y") ) }}</span>
                                                <span class="users__text--data users__text--data-block-hira">No: {{ $bag->key }}</span>
                                            </div>

                                            <div class="users__status-container">
                                                <span class="users__text--data users__text--data-status">{{ $bag->bagStatus->label }}</span>
                                            </div>

                                            <div class="users__link-container">
                                                <a href="{{ $bag->thank_you_page_url }}" class="users__link">Órden de compra</a>
                                            </div>
                                            <div class="divisor"></div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </div>
@endsection
