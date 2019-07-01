@extends('layouts.admin')

@section('title')
    Editar | {{ $product_edit->title }}
@endsection

@section('h1')
    Editar: <small class="text__p-medium">{{ $product_edit->code }}</small>
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            @include('admin.general._page-instructions', [
                'title'         =>  '',
                'instructions'  =>  'Edita el producto. Da click en el enlace para ir al single del producto.'
            ])
            <h2 class="text__subtitle text__subtitle--no-margin"><strong>{{ $product_edit->title }}</strong></h2>
            <a href="{{ $product_edit->client_url }}" class="link-underline">Ver producto</a>
        </div>
    </div>

    @include('admin.products._basic_info_form', [
        "form_id"       => 'update_product-'.$product_edit->id.'-_form',
        "form_route"    => ['admin::products.update',$product_edit->id],
        "form_method"   => 'PATCH',
        "form_submit"   => 'Guardar'
    ])

    <div class="row">

        <div class="col-xs-12">

            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    @include('admin.general._page-instructions', [
                        'title'         =>  'Imágenes',
                        'instructions'  =>  'Agrega o elimina la imagen del producto.'
                    ])
                    @include('admin.products.edit._photos')
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    @include('admin.general._page-instructions', [
                        'title'         =>  'Secciones',
                        'instructions'  =>  'Agrega, edita o elimina secciones.'
                    ])
                    @include('admin.products.edit._sections')
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    @include('admin.general._page-instructions', [
                        'title'         =>  'Skus',
                        'instructions'  =>  'Agrega, edita o desactiva skus.'
                    ])
                    <product-skus :list.sync="store.skus.data" v-ref:product_skus></product-skus>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1">
                    @include('admin.general._page-instructions', [
                        'title'         =>  'Productos relacionados',
                        'instructions'  =>  'Agrega uno o más productos relacionados'
                    ])
                    @include('admin.products.edit._related')
                </div>
            </div>

            <div class="row">
                <div class="col-xs-12">
                    <hr>
                </div>
            </div>

            <div class="row">
                <div class="col-xs-10 col-xs-offset-1 col-md-5">
                    @include('admin.general._page-instructions', [
                        'title'         =>  'subcategorías',
                        'instructions'  =>  'Agrega o elimina subcategorías.'
                    ])
                    @include('admin.products.edit._checkboxes', ['kind_plural' => 'subcategories', 'kind_singular' => 'subcategory', 'kind_singular_translated' =>  'subcategoría', 'parent_singular' => 'category'])
                </div>
                <div class="col-xs-10 col-xs-offset-1 col-md-5 col-md-offset-0">
                    @include('admin.general._page-instructions', [
                        'title'         =>  'subtipos de eventos',
                        'instructions'  =>  'Agrega o elimina subtipos de eventos.'
                    ])
                    @include('admin.products.edit._checkboxes', ['kind_plural' => 'subtypes', 'kind_singular' => 'subtype', 'kind_singular_translated'  =>  'subtipo', 'parent_singular' => 'type'])
                </div>
            </div>

        </div>

    </div>

@endsection

@section('modals')
    @include('admin.media_manager._mediaManager')
    @include('admin.skus._modal-create')
    @include('admin.skus._modal-edit')
    @include('admin.products.edit._modal-section-edit')
    @include('admin.products.edit._modal-section-create')
    @include('admin.products.providers._modal-create')
    @include('admin.events.types.subtypes._modal-create')
    @include('admin.products.categories.subcategories._modal-create')
    @include('admin.products.edit._modal-related')
@endsection


@section('vue_templates')
    @include('admin.media_manager.vue.single-image-template')
    @include('admin.products.edit._product-skus-template')

    <script type="x/templates" id="single-sku-template">
        @include('admin.products.edit.single-sku-template')
    </script>
@endsection

@section('vue_store')
    <script>

        mainVueStore.providers = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::providers.ajax.index')}}'
            }
        };

        mainVueStore.sections = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::products.secciones.ajax.index',$product_edit->id)}}'
            }
        };

        mainVueStore.skus = {
            data: undefined, //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::products.skus.ajax.index',$product_edit->id)}}'
            }
        };

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

        mainVueStore.products = {
            data: [], //IMPORTANTE: tenemos que registrar esta propiedad para que el get deposite lo recibido ahí, y SOBRETODO  para que el sistema de reactividad de Vue funcione adecuadamente
            routes: {
                get: '{{route('admin::products.ajax.index')}}'
            }
        };

        mainVueStore.current_product = {
            data: {
                subcategories: {},
                subtypes: {},
                products_related: {}
            },
            routes:  {
                get: '{{route('admin::products.ajax.show',$product_edit->id)}}'
            }
        }

        mainVueStore.related_products_ids = [];
    </script>
@endsection
