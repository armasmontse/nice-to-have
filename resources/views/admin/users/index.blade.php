@extends('layouts.admin')


@section('title')
    Lista de Usuarios |
@endsection

@section('h1')
    Lista de Usuarios
@endsection



@section('content')
    <div class="row">
        <div class="col-xs-12 ">
            @include('admin.users.index._table')
        </div>
    </div>
@endsection
