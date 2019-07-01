{!! Form::open([
    'method'                => 'POST',
    'route'                 => ['admin::categories.ajax.store'],
    'role'                  => 'form' ,
    'id'                    => 'create_category_form',
    'class'                 => 'row',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="col-xs-offset-1 col-xs-2">
        <div class="form-group">
            {!! Form::label("order", 'Orden:', ['class' => 'input-label']) !!}
            {!! Form::number("order", null, [
                'class'       => 'form-control input',
                'placeholder' => "10",
                'required'    => 'required',
                'step'        => 1,
                "min"         => 0,
                'form'        => 'create_category_form'
            ]) !!}
        </div>
    </div>

    <div class="col-xs-6 ">
        @foreach($languages as $language)
            <div class="form-group">
                {!! Form::label("label[".$language->iso6391."]", 'Nombre:', ['class' => 'input-label']) !!}
                {!! Form::text("label[".$language->iso6391."]", null, [
                    'class'       => 'form-control input',
                    'placeholder' => "Hogar",
                    'required'    => 'required',
                    'form'        => 'create_category_form'
                ]) !!}
            </div>
        @endforeach
    </div>

    <div class="col-xs-3 button__col">
        <div class="btn-group pull-right">
            {!! Form::submit('Guardar', [
                'class'      => 'btn btn-info button',
                'form'       => 'create_category_form'
            ]) !!}
        </div>
    </div>

{!!Form::close()!!}
