<!DOCTYPE html>
<html lang="{{ session('lang') }}">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1.0, user-scalable=no">

        @if (is_page('client::events-alt.show'))
            <link href="{{route('client::events.show', $event->slug)}}" rel="canonical" />
        @endif

        @if (is_page("client::events.shop.single"))
            <link href="{{route('client::single.show', $product->slug)}}" rel="canonical" />
        @endif

        <title>{{ env("APPNOMBRE") }} | @yield('title')</title>

        <!-- Styles -->
            {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/twitter-bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous"> --}}
        <!-- Fonts -->
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.5.0/css/font-awesome.min.css" integrity="sha384-XdYbMnZ/QjLh6iI4ogqCTaIjrFk87ip+ekIjefZch0Y+PvJ8CDYtEs1ipDmPorQ+" crossorigin="anonymous">
        {{-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/Swiper/3.2.7/css/swiper.css"> --}}

        {{-- Favicon --}}
        @include('general.favicon')

        {{-- @if($asset_versioning) --}}
            {{-- {!! Html::style(elixir('css/mazorca.css')) !!} --}}
        {{-- @else --}}
            {!! Html::style('css/mazorca.css')!!}
        {{-- @endif --}}

        {{-- <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.1.0/jquery.min.js"></script> --}}
        <script>window.jQuery || document.write('<script src="{{ asset('js/jquery.js')}}"><\/script>')</script>
        @if (!env('CLTVO_DEV_MODE'))
            @include('client.general._analytics')
        @endif
    </head>

<body
    id="{{isset($body_id) ? $body_id : 'main-vue'}}"
    class="body {{isset($body_class) ? $body_class : ''}}"
    :class="{
        'no-scroll': bodyScrollIsDisabled
    }"
    @click="closeOpenStuff"
    v-cloak>
    @include('client.general.header')
    @include('client.general._alerts')
    <menu-mobile :total-items-in-bags="totalItemsInBags" :menu="'main'" :is-open="store.menus.main.isOpen"></menu-mobile>

    {{-- @include('layouts.client.menus._menuResponsive') --}}

    {{-- @yield('page-menu') --}}
    @yield('content')


    @include('client.general._footer')
    @include('client.general.scripts')
	@yield('modals')
{{-- templates generales de Vue --}}
    @include('client.menus.menu-mobile-template')
    @include('client.general.vue.shoppingBagMenu')
    @include('client.general.vue.userAccountMenu')
{{-- Templates particulares a ciertas páginas --}}
 	@yield('vue_templates')
</body>

</html>
