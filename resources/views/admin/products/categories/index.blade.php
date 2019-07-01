@extends('layouts.admin')


@section('title')
    Categorías de productos |
@endsection

@section('h1')
    Categorías de productos
@endsection



@section('content')

<categories :list="store.categories.data"></categories>
<script type="x/templates" id="categories-template">
    <div class="row">

        @include('admin.general._page-subtitle', ['title' => 'agregar categoría'])

        <div class="col-xs-10 col-xs-offset-1">
            @include('admin.products.categories._create-form')
        </div>

        <div class="col-xs-12">
            <hr>
        </div>

        <div class="col-xs-10 col-xs-offset-1">
            <div class="row" {{-- v-for="category in list" --}}>
                {{-- @include('admin.products.categories._delete-form')
                @include('admin.products.categories._edit-form') --}}
                @include('admin.products.categories._table')
            </div>
        </div>

    </div>
</script>
@endsection

@section('modals')
    @include('admin.products.categories._modal-edit')
@endsection

@section('vue_store')
    <script>
        mainVueStore.categories = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::categories.ajax.index')}}'
            }
        };
    </script>
@endsection
