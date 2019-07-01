{!! Form::open([
    'method'             => $form_method,
    'route'              => $form_route,
    'role'               => 'form' ,
    'id'                 => $form_id,
    'class'              => 'row',
    ]) !!}

<div class="col-xs-10 col-xs-offset-1">
    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                {!! Form::label('first_name', "Nombre(s):", ['class' => 'input-label']) !!}
                {!! Form::text('first_name', $user_edit->first_name, [
                    'class'         => 'form-control input',
                    'required'      => 'required',
                    'form'          => $form_id,
                    'placeholder'   =>  "María"
                    ]) !!}
            </div>
        </div>

        <div class="col-xs-6">
            <div class="form-group">
                {!! Form::label('last_name',"Apellido(s):", ['class' => 'input-label']) !!}
                {!! Form::text('last_name', $user_edit->last_name, [
                    'class'         => 'form-control input',
                    'required'      => 'required',
                    'form'          => $form_id,
                    'placeholder'   => "Pérez"
                    ]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-6">
            <div class="form-group">
                {!! Form::label('email', "Email:", ['class' => 'input-label']) !!}
                {!! Form::email('email', $user_edit->email, [
                    'class'       => 'form-control input',
                    'required'    => 'required',
                    'form'        => $form_id,
                    'placeholder' => "ejemplo@ejemplo.com"
                    ]) !!}

            </div>
        </div>

        <div class="col-xs-6">
            <div class="form-group">
                {!! Form::label('roles', "Roles:", ['class' => 'input-label']) !!}
                <div class=" input__select-container">
                    {!! Form::select('roles[]', $rolesList, $user_edit->getFirstRoleId(), [
                        'class'         => 'form-control input__select',
                        'required'      => 'required',
                        'placeholder'   => "Seleccionar",
                        'form'          => $form_id,
                        "id"            => "roles"
                    ])  !!}
                    <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row ">
        <div class="col-xs-12 button__col">
            <div class="btn-group pull-right">
                {!! Form::submit("Guardar", [
                    'class' => 'btn btn-info button',
                    'form'  => $form_id
                ]) !!}
            </div>
        </div>
    </div>
</div>

{!! Form::close() !!}
