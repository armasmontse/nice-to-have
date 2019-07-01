@extends('layouts.admin')


@section('title')
    Usuarios desactivados
@endsection


@section('h1')
    Usuarios desactivados
@endsection


@section('content')
    <div class="row">
        <div class="col-xs-12 ">
            @include('admin.users.trash._table')
        </div>
    </div>
@endsection
