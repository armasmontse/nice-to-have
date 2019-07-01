<nav class="navbar navbar-inverse navbar-fixed-top menu">
    <div class="container-fluid">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed menu__navbar-toggle" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
            </button>

            <div class="menu__logo-container">
                <a href="{{route("client::pages.index")}}">{!! file_get_contents('images/logo-admin.svg')!!}</a>
            </div>
        </div>

        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav navbar-right menu__link">

                <li><a href="{{ route("admin::index") }}" class="link">Admin</a></li>
                <li><a href="{{ route("client::pages.index") }}" class="link">Ver Sitio</a></li>
                <li >
                    {!! Form::open(['method' => 'PATCH', 'route' => 'admin::cache.update']) !!}
                        {!! Form::submit("Actualizar tienda",
                            [
                                'class' => 'button__as-link',
                                'style' => isShopCacheUpdated() ? "" : "color: #ea7640;",
                        ]) !!}
                    {!! Form::close() !!}
                </li>
                <li>
                    {!! Form::open(['method' => 'POST', 'route' => 'client::logout']) !!}
                            {!! Form::submit("Logout", ['class' => 'button__as-link']) !!}
                    {!! Form::close() !!}
                </li>
            </ul>
        </div>
    </div>
</nav>
