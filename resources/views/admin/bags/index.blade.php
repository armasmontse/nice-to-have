@extends('layouts.admin')


@section('title')
    Lista de carritos |
@endsection

@section('h1')
    Lista de carritos
@endsection

@section('content')

    <div class="row">

        <div class="col-xs-12">

            @include('admin.bags._table')

        </div>

    </div>

@endsection
