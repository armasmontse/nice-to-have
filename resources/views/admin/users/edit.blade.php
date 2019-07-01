@extends('layouts.admin')

@section('title')
    Editar Usuario
@endsection

@section('h1')
    Editar Usuario
@endsection

@section('content')

    <div class="row">
        <div class="col-xs-12 ">
            @include('admin.users._form',[
                "form_id"       => 'edit_user_form',
                "form_route"   => ['admin::users.update',$user_edit->id],
                "form_method"   => 'PATCH'
            ])
        </div>
    </div>
@endsection
