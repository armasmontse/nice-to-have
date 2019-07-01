<!DOCTYPE html>
<html lang="{{ session('lang') }}">
    @include('client.general.head')

<body
    id="{{isset($body_id) ? $body_id : 'main-vue'}}"
    class="body"
    @click="closeOpenStuff"
    v-cloak>
    @include('client.general.header' )
    @include('client.general._alerts')
    {{-- @include('layouts.client.menus._menuResponsive') --}}

    {{-- @yield('page-menu') --}}
    @yield('content')


    @include('client.general._footer')
    @include('client.general.scripts')
	@yield('modals')
{{-- templates generales de Vue --}}
    @include('client.general.vue.shoppingBagMenu')
    @include('client.general.vue.userAccountMenu')
{{-- Templates particulares a ciertas páginas --}}
 	@yield('vue_templates')
</body>

</html>
