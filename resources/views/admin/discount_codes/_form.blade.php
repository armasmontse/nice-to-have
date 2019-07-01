{!! Form::open([
    'method'    => $form_method,
    'route'     => $form_route,
    'role'      => 'form' ,
    'id'        => $form_id,
    'class'     => 'row'
]) !!}

    <div class="row">
        <div class="col-xs-6 col-xs-offset-1">
            <div class="form-group">
                {!! Form::label('code', 'Código:', ['class' => 'input-label']) !!}
                {!! Form::text('code', $discount_code->code, [
                    'class'         => 'form-control input',
                    'required'      => 'required',
                    'form'          => $form_id,
                    'placeholder'   => 'Código',
                    'maxlength'     => 12,
                    $disabled
                ]) !!}
            </div>
        </div>

        <div class="col-xs-3 col-xs-offset-1">
            <div class="form-group">
                {!! Form::label('type', 'Tipos de código de descuento:', ['class' => 'input-label']) !!}
                <div class="input__select-container">
                    {!! Form::select('type', $discount_codes_types, $discount_code->discount_code_type_id, [
                        'class'         => 'form-control input__select',
                        'required'      => 'required',
                        'placeholder'   => 'Seleccionar',
                        'form'          => $form_id,
                        'id'            => 'discount_code_type',
                        $disabled
                    ])  !!}
                    <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-3 col-xs-offset-1 row-mt">
            <div class="form-group">
                {!! Form::label('initial_date', 'Fecha de inicio:', ['class' => 'input-label']) !!}
                {!! Form::date('initial_date', $discount_code->initial_date ? $discount_code->initial_date->format('Y-m-d') : null, [
                    'class'         => 'form-control input',
                    'required'      => 'required',
                    'placeholder'   => date('Y-m-d'),
                    'form'          => $form_id
                ]) !!}
            </div>
        </div>

        <div class="col-xs-3 col-xs-offset-1 row-mt">
            <div class="form-group">
                {!! Form::label('end_date', 'Fecha de caducidad:', ['class' => 'input-label']) !!}
                {!! Form::date('end_date', $discount_code->end_date ? $discount_code->end_date->format('Y-m-d') : null, [
                    'class'         => 'form-control input',
                    'required'      => 'required',
                    'placeholder'   => date('Y-m-d'),
                    'form'          => $form_id
                ]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-2 col-xs-offset-1 row-mt">
            <div class="form-group">
                {!! Form::label('value', 'Descuento:', ['class' => 'input-label', 'id' => 'discount_code_value_label']) !!}
                {!! Form::number('value', $discount_code->value, [
                    'class'         => 'form-control input',
                    'form'          => $form_id,
                    'placeholder'   => 'Descuento',
                    'min'           => 0,
                    'id'            => 'discount_code_value',
                    $disabled
                ]) !!}
            </div>
        </div>

        <div class="col-xs-2 col-xs-offset-6 row-mt">
            <div class="form-group">
                <div class="pull-right">
                    {!! Form::label('unique', 'Código único:', ['class' => 'switch-label']) !!}
                    <div class="switch">
                        {!! Form::checkbox('unique', true, $discount_code->unique, [
                            'class'         => 'input__checkbox',
                            'form'          => $form_id,
                            'data-toggle'   => 'toggle',
                            'data-on'       => 'Si',
                            'data-off'      => 'No',
                            'data-onstyle'  => 'default',
                            $disabled
                        ]) !!} 
                        <span class="lever"></span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-10 col-xs-offset-1 row-mt">
            <div class="form-group">
                {!! Form::label('description', 'Descripción:', ['class' => 'input-label']) !!}
                {!! Form::textarea('description', $discount_code->description ? $discount_code->description : null, [
                    'class'         => 'form-control input',
                    'required'      => 'required',
                    'form'          => $form_id,
                    'rows'          => 3,
                    'placeholder'   => 'Agregar descripción del código de descuento',
                    $disabled
                ]) !!}
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-xs-11 button__col">
            <div class="btn-group pull-right">
                {!! Form::submit('Guardar', [
                    'class' => 'btn btn-info button',
                    'form'  => $form_id
                ]) !!}
            </div>
        </div>
    </div>

{!! Form::close() !!}