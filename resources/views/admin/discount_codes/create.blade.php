 @extends('layouts.admin')

@section('title')
    Agregar código de descuento |
@endsection

@section('h1')
    Agregar código de descuento
@endsection

@section('content')
    
    @include('admin.discount_codes._form', [
        'form_method'   => 'POST',
        'form_route'    => ['admin::discount_codes.store'],
        'form_id'       => 'create_discount_code_form',
        'disabled'		=> ''
    ])

@endsection