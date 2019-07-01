<div class="userAccountMenu__link-container" style="width: 140px">
    @if ($user)
        @if ($user->hasPermission("admin_access"))
            <a class="userAccountMenu__link" href="{{route("admin::index")}}"  >
                Admin
            </a>
        @endif

        <a class="userAccountMenu__link" href="{{route("user::wishlist.index",$user->name)}}" >
            @if ($user->hasPermission("admin_access"))
                <span class="userAccountMenu__dash">_</span>
            @endif
            Favoritos
        </a>
        <a class="userAccountMenu__link" href="{{route("user::home",$user->name)}}" >
                <span class="userAccountMenu__dash">_</span>
            Perfil
        </a>
    @endif
    {{-- <a class="userAccountMenu__link" href="{{route("client::bags.index")}}" >
            <span class="userAccountMenu__dash">_</span>
        Compras
    </a> --}}

    @if ($cookie_event)
        {{-- con evento pendiente --}}
            <a class="userAccountMenu__link" href="{{ $cookie_event->shop_url }}"  >
                <span class="userAccountMenu__dash">_</span>
                {{ $cookie_event->name }}
            </a>
    @endif


    @if ($user)
        {!! Form::open(['method' => 'POST', 'route' => 'client::logout', "class" => "userAccountMenu__button-as-link-container"]) !!}
            <span class="userAccountMenu__dash">_</span>
            {!! Form::submit("Cerrar sesión", ['class' => 'userAccountMenu__button-as-link']) !!}
        {!! Form::close() !!}
    @else
        <div>
            <a class="userAccountMenu__link userAccountMenu__link-login" href="{{route("client::login:get")}}">
                <span class="userAccountMenu__dash">_</span>
                Iniciar sesión
            </a>
        </div>
    @endif
</div>
