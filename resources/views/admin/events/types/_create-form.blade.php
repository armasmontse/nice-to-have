{!! Form::open([
    'method'                => 'POST',
    'route'                 => ['admin::types.ajax.store'],
    'role'                  => 'form' ,
    'id'                    => 'create_type_form',
    'class'                 => 'row',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="col-xs-8 col-xs-offset-1">
        <div class="row">
            <div class="col-xs-3">
                <div class="form-group">
                    {!! Form::label("order", 'Orden:', ['class' => 'input-label']) !!}
                    {!! Form::number("order", null, [
                        'class'       => 'form-control input',
                        'placeholder' => "10",
                        'required'    => 'required',
                        'step'        => 1,
                        "min"         => 0,
                        'form'        => 'create_type_form'
                    ]) !!}
                </div>
            </div>
            @foreach($languages as $language)
                <div class="col-xs-9">
                    <div class="form-group">
                        {!! Form::label("label[".$language->iso6391."]", 'Nombre:', ['class' => 'input-label']) !!}
                        {!! Form::text("label[".$language->iso6391."]", null, [
                            'class'       => 'form-control input',
                            'placeholder' => "boda",
                            'required'    => 'required',
                            'form'        => 'create_type_form'
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label("title[".$language->iso6391."]", 'Título:', ['class' => 'input-label']) !!}
                        {!! Form::text("title[".$language->iso6391."]", null, [
                            'class'       => 'form-control input',
                            'placeholder' => "Lorem ipsum dolor sit amet...",
                            // 'required'    => 'required',
                            'form'        => 'create_type_form'
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label("description[".$language->iso6391."]", 'Descripción:' , ['class' => 'input-label']) !!}
                        {!! Form::textarea("description[".$language->iso6391."]", null, [
                            'class'       => 'form-control input',
                            'placeholder' => "Prompta senserit usu eu, et eum movet ludus euripidis...",
                            // 'required'    => 'required',
                            'rows'         => '2',
                            'form'        => 'create_type_form'
                        ]) !!}
                    </div>
                </div>
            @endforeach
        </div>
    </div>

    <div class="col-xs-3 button__col">
        <div class="btn-group pull-right">
            {!! Form::submit('Guardar', [
                'class'      => 'btn btn-info button',
                'form'       => 'create_type_form'
            ]) !!}
        </div>
    </div>

{!!Form::close()!!}
