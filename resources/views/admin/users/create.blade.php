@extends('layouts.admin')


@section('title')
    Crear Usuario
@endsection

@section('h1')
    Crear Usuario
@endsection

@section('content')
    <div class="row">
        <div class="col-xs-12 ">

                    @include('admin.users._form',[
                        "form_id"       => 'create_user_form',
                        "form_route"   => ['admin::users.store'],
                        "form_method"   => 'POST'
                    ])

        </div>
    </div>
@endsection
