@extends('layouts.admin')

@section('title')
    Editar código de descuento |
@endsection

@section('h1')
    Editar código de descuento
@endsection

@section('content')

    @include('admin.discount_codes._form', [
        'form_method'   => 'PATCH',
        'form_route'    => ['admin::discount_codes.update', $discount_code->id],
        'form_id'       => 'update_discount_code_form',
        'disabled'		=> 'disabled'
    ])

@endsection