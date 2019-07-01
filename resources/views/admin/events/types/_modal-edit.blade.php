@extends('layouts.modal',["modal_id"=> "type-edit"])

@section('modal-title')
    Editar tipo de evento
@overwrite

@section('modal-content')

    <types-modal-edit :list.sync="store.types.data" :edit-index="0"></types-modal-edit>
    <script type="x/templates" id="types-modal-edit-template">
        @include('admin.events.types._edit-form')
    </script>

@overwrite
