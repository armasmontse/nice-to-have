@extends('layouts.modal',["modal_id"=> "subcategory-create"])

@section('modal-title')
    Agregar subcategoría
@overwrite

@section('modal-content')
<subcategories :list.sync="store.subcategories.data" :categories="store.categories.data"></subcategories>
<script type="x/templates" id="subcategories-template">
    @include('admin.products.categories.subcategories._create-form')
</script>
@overwrite
