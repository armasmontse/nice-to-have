@extends('layouts.modal',["modal_id"=> "subtype-edit"])

@section('modal-title')
    Editar tipo de evento
@overwrite

@section('modal-content')

    <subtypes-modal-edit :list.sync="store.subtypes.data" :types="store.types.data" :edit-index="0"></subtypes-modal-edit>
    <script type="x/templates" id="subtypes-modal-edit-template">
        @include('admin.events.types.subtypes._edit-form')
    </script>

@overwrite
