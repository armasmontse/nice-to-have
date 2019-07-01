@extends('layouts.modal',["modal_id"=> "provider-edit"])

@section('modal-title')
    Editar proveedor
@overwrite

@section('modal-content')

    <providers-modal-edit :list.sync="store.providers.data" :edit-index="0"></providers-modal-edit>
    <script type="x/templates" id="providers-modal-edit-template">
        @include('admin.products.providers._edit-form')
    </script>

@overwrite
