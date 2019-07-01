@extends('layouts.modal', ["modal_id"=> "category-edit"])

@section('modal-title')
    Editar categoría
@overwrite

@section('modal-content')

    <categories-modal-edit :list.sync="store.categories.data" :edit-index="0"></categories-modal-edit>

    <script type="x/templates" id="categories-modal-edit-template">
    	<div>
        @include('admin.products.categories._edit-form')
    	</div>
    </script>

@overwrite
