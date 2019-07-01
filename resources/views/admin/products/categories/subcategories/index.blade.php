@extends('layouts.admin')


@section('title')
    Subcategorías de productos |
@endsection

@section('h1')
    Subcategorías de productos
@endsection



@section('content')

<subcategories :list="store.subcategories.data" :categories="store.categories.data" :current-language="store.current_language"></subcategories>
<script type="x/templates" id="subcategories-template">
    <div class="row">

        @include('admin.general._page-subtitle', ['title' => 'agregar subcategoría'])

        <div class="col-xs-10 col-xs-offset-1">
            @include('admin.products.categories.subcategories._create-form')
        </div>

        <div class="col-xs-12">
            <hr>
        </div>

        <div class="col-xs-10 col-xs-offset-1">
            <div class="row">
                @include('admin.products.categories.subcategories._table')
            </div>
        </div>

    </div>
</script>

@endsection

@section('modals')
    @include('admin.products.categories.subcategories._modal-edit')
@endsection

@section('vue_store')
    <script>
        mainVueStore.subcategories = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::subcategories.ajax.index')}}'
            }
        };
        mainVueStore.categories = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::categories.ajax.index')}}'
            }
        };
    </script>
@endsection
