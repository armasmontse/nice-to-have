@extends('layouts.admin')

@section('title')
    Administrador de páginas
@endsection

@section('h1')
    Administrador de páginas
@endsection

@section('action')
    <a href="{{ route( 'admin::pages.create' ) }}" class="btn-floating">
        <i class="material-icons waves-effect waves-light " >add</i>
    </a>
@endsection

@section('content')

    <div class="col-md-10 col-md-offset-1">
        <div class="row">
            @include('admin.pages.index._table')
        </div>
    </div>

@endsection
