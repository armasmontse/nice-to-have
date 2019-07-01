<!DOCTYPE html>
<html lang="{{ session('lang') }}">
    @include('client.general.head')

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
