<div class="menuResponsive__visible">
    <div class="grid__row">
        <div class="grid__container menuResponsive__container-visible">
            <span class="menuResponsive__icon menuResponsive__icon-position_JS">menu</span>
            <div class="menuResponsive__col menuResponsive__logo-col">{!! file_get_contents('images/logo-menuResponsive.svg')!!}</div>
        </div>
    </div>
</div>

<div class="grid__row">
    <div class="grid__container">
        <div class="menuResponsive__container-arrow">{!! file_get_contents('images/icon-menu.svg')!!}</div>
    </div>
</div>

<nav id="menuResponsive" class="menuResponsive">
    <div class="grid__row">
        <div class="grid__container menuResponsive__container">
            <span id="menuResponsive__icon" class="menuResponsive__icon">{{ trans('menu.responsive.close') }}</span>

            <a class="menuResponsive__link" href="{{ URL::to($current_lang_iso."/".trans("routes.shop") )}}">{{trans("menu.main.shop")}}</a>
            <a class="menuResponsive__link" href="{{ URL::to($current_lang_iso."/".trans("routes.collections") )}}">{{trans("menu.main.collections")}}</a>
            <a class="menuResponsive__link " href=" {{ URL::to($current_lang_iso."/magazine" )}}">magazine  <br></a>
            <a class="menuResponsive__link " href=" {{ URL::to($current_lang_iso."/mm")}}       ">mm <br></a>

                <a class="menuResponsive__link" href="{{ URL::to( $current_lang_iso.'/'.trans("routes.login")) }}">{{ trans("menu.top.login") }}</a>
                <a class="menuResponsive__link" href="{{ URL::to($current_lang_iso.'/'.trans("routes.shopping_bag")."/".$bag_key) }}">
                    {{ trans("menu.top.shopping_bag") }}
                    <span id="shoppingBag__quantity">(0)</span>
                </a>
                <a class="menuResponsive__link" href="">{{ trans("menu.top.search") }}</a>

            <div class="menuResponsive__menuLang">
                @foreach ( $languages as $language)

                <a class="menuResponsive__link menuResponsive__link--language" href="{{  url('lang', [$language->iso6391]) }}">{{$language->iso6391}}</a>

                @endforeach
            </div>
        </div>
    </div>
</nav>
