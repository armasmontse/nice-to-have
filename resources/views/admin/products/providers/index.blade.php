@extends('layouts.admin')


@section('title')
    Lista de proveedores |
@endsection

@section('h1')
    Proveedores
@endsection

@section('content')

<providers :list="store.providers.data"></providers>
<script type="x/templates" id="providers-template">
    <div class="row">

        @include('admin.general._page-subtitle', ['title' => 'agregar proveedor'])

        {{-- borrar  --}}
        <div class="col-xs-10 col-xs-offset-1">
            @include('admin.products.providers._create-form')
        </div>

        <div class="col-xs-12">
            <hr>
        </div>

        <div class="col-xs-10 col-xs-offset-1">
            <div class="row">
                @include('admin.products.providers._table')
            </div>
        </div>

    </div>
</script>
@endsection

@section('modals')
    {{-- @include('admin.products.providers._modal-create') --}}
    @include('admin.products.providers._modal-edit')
@endsection

@section('vue_store')
    <script>
        mainVueStore.providers = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::providers.ajax.index')}}'
            }
        };
    </script>
@endsection
