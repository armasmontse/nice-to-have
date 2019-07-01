@extends('layouts.admin')

@section('title')
    Lista de códigos de descuento |
@endsection

@section('h1')
    Códigos de descuento
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-10 col-xs-offset-1">
            <div class="row">
                @include('admin.discount_codes.index._table')
            </div>
        </div>
    </div>
@endsection