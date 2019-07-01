@extends('layouts.admin')

@section('title')
    Papelera de productos
@endsection

@section('h1')
    Papelera de productos
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 ">
            @include('admin.products.trash._table')
        </div>
    </div>
@endsection
