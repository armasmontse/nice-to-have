@extends('layouts.admin')


@section('title')
    Lista de eventos |
@endsection

@section('h1')
    Lista de eventos
@endsection



@section('content')

    <div class="row">

        <div class="col-xs-12 ">

            @include('admin.events.index._table')

        </div>

    </div>

@endsection
