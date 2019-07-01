@extends('layouts.admin')


@section('title')
    Subtipos de eventos |
@endsection

@section('h1')
    Subtipos de eventos
@endsection



@section('content')

<subtypes :list="store.subtypes.data" :types="store.types.data"></subtypes>
<script type="x/templates" id="subtypes-template">
    <div class="row">

        @include('admin.general._page-subtitle', ['title' => 'agregar subtipo'])

        <div class="col-xs-10 col-xs-offset-1">
            @include('admin.events.types.subtypes._create-form')
        </div>

        <div class="col-xs-12">
            <hr>
        </div>

        <div class="col-xs-10 col-xs-offset-1">
            <div class="row">
                @include('admin.events.types.subtypes._table')
            </div>
        </div>

    </div>
</script>

@endsection

@section('modals')
    @include('admin.events.types.subtypes._modal-edit')
@endsection

@section('vue_store')
    <script>
        mainVueStore.subtypes = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::subtypes.ajax.index')}}'
            }
        };
        mainVueStore.types = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::types.ajax.index')}}'
            }
        };
    </script>
@endsection
