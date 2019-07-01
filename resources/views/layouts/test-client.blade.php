<!DOCTYPE html>
<html lang="en">
@include('client.general.head')

<body id="@if(isset($body_id)){{$body_id}}@endif" class="body" @if(isset($body_id)) v-cloak @endif>
    @yield('content')

    @include('client.general.scripts')
    @yield('vue_templates')
    @include('client.general.vue.shoppingBagMenu')
    @include('client.general.vue.userAccountMenu')
</body>
</html>
