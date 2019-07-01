{!! Form::open([
    'method'                => 'POST',
    'route'                 => ['admin::providers.ajax.store'],
    'role'                  => 'form' ,
    'id'                    => 'create_provider_form',
    'class'                 => 'row',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="col-xs-8 col-xs-offset-1">
        <div class="form-group">
            {!! Form::label("label", 'Nombre(s)', ['class' => 'input-label']) !!}
            {!! Form::text("label", null, [
                'class'         => 'form-control input',
                'placeholder'   => 'Cultivo',
                'required'      => 'required',
                'form'          => 'create_provider_form'
            ]) !!}
        </div>
    </div>

    <div class="col-xs-2 button__col">
        <div class="btn-group pull-right">
            {!! Form::submit('Guardar', [
                'class'      => 'btn btn-info button',
                'form'       => 'create_provider_form'
            ]) !!}
        </div>
    </div>

{!!Form::close()!!}
