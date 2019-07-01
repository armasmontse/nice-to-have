@extends('layouts.admin')

@section('title')
    Lista de códigos de descuento desactivados |
@endsection

@section('h1')
    Códigos de descuento desactivados
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="row">
                @include('admin.discount_codes.trash._table')
            </div>
        </div>
    </div>
@endsection