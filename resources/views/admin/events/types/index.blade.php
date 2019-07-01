@extends('layouts.admin')


@section('title')
    Tipos de eventos |
@endsection

@section('h1')
    Tipos de eventos
@endsection



@section('content')
<types :list="store.types.data"
    v-ref:types></types>
<script type="x/templates" id="types-template">
    <div class="row">

        @include('admin.general._page-subtitle', ['title' => 'agregar tipo de evento'])

        <div class="col-xs-10 col-xs-offset-1">
            @include('admin.events.types._create-form')
        </div>

        <div class="col-xs-12">
            <hr>
        </div>

        <div class="col-xs-10 col-xs-offset-1">
            <div class="row">
                @include('admin.events.types._table')
            </div>
        </div>

    </div>
</script>
@endsection

@section('modals')
    @include('admin.events.types._modal-edit')
@endsection

@section('vue_templates')
    @include('admin.media_manager.vue.single-image-template')
    @include('admin.media_manager._mediaManager')
@endsection


@section('vue_store')
    <script>
        mainVueStore.types = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::types.ajax.index')}}'
            }
        };
    </script>
@endsection
