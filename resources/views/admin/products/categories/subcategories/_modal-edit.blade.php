@extends('layouts.modal', ["modal_id"=> "subcategory-edit"])

@section('modal-title')
    Editar subcategoría
@overwrite

@section('modal-content')

    <subcategories-modal-edit :list.sync="store.subcategories.data" :categories="store.categories.data" :current-language="store.current_language" :edit-index="0"></subcategories-modal-edit>
    <script type="x/templates" id="subcategories-modal-edit-template">
        @include('admin.products.categories.subcategories._edit-form')
    </script>

@overwrite
