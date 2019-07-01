@extends('layouts.modal',["modal_id"=> "subtype-create"])

@section('modal-title')
    Agregar subtipo de evento
@overwrite

@section('modal-content')
<subtypes :list.sync="store.subtypes.data" :types="store.types.data"></subtypes>
<script type="x/templates" id="subtypes-template">
    @include('admin.events.types.subtypes._create-form')
</script>
@overwrite
