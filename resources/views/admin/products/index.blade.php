@extends('layouts.admin')

@section('title')
    Lista de Productos
@endsection

@section('h1')
    Lista de Productos
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
            @include('admin.products.index._table')
        </div>
    </div>
@endsection
