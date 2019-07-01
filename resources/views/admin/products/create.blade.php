@extends('layouts.admin')

@section('title')
    Crear Producto
@endsection

@section('h1')
    Crear Producto
@endsection

@section('content')
    @include('admin.products._basic_info_form',[
        "form_id"       => 'create_product_form',
        "form_route"    => ['admin::products.store'],
        "form_method"   => 'POST',
        "form_submit"   => 'Crear'
    ])
@endsection

@section('modals')
    @include('admin.products.providers._modal-create')
@endsection

@section('vue_store')
    <script>
		mainVueStore.current_product = {};
        mainVueStore.providers = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::providers.ajax.index')}}'
            }
        };
    </script>
@endsection
