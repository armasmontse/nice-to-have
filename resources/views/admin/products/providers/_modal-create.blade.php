@extends('layouts.modal',["modal_id"=> "provider-create"])

@section('modal-title')
    Agregar proveedor
@overwrite

@section('modal-content')
<providers-modal :list.sync="store.providers.data"></providers-modal>
<script type="x/templates" id="providers-modal-template">
    @include('admin.products.providers._create-form')
</script>
@overwrite
