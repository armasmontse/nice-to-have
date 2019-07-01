{!! Form::open([
    'method'                => 'POST',
    'route'                 => ['admin::subtypes.ajax.store'],
    'role'                  => 'form' ,
    'id'                    => 'create_subtype_form',
    'class'                 => 'row',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="col-xs-8 col-xs-offset-1">
        <div class="row">
            <div class="col-xs-9">
                <div class="form-group">
                    {!! Form::label('type_id', 'Tipo de evento', ['class' => 'input-label']) !!}
                    <div class="input__select-container">
                        <select class="form-control input__select"
                                required="required"
                                form="create_subtype_form"
                                name="type_id"
                                id="type_id">
                            <option value="" selected="selected" disabled="disabled">Seleccionar</option>
                            <option :value="type.id" v-for="type in types">&#123;&#123; type.{{ $current_lang_iso }}_label&#125;&#125;</option>
                        </select>
                        <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    {!! Form::label("order", 'Orden:', ['class' => 'input-label']) !!}
                    {!! Form::number("order", null, [
                        'class'       => 'form-control input',
                        'placeholder' => "10",
                        'required'    => 'required',
                        'step'        => 1,
                        "min"         => 0,
                        'form'        => 'create_subtype_form'
                    ]) !!}
                </div>
            </div>
            @foreach($languages as $language)
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label("label[".$language->iso6391."]", 'Nombre:', ['class' => 'input-label']) !!}
                        {!! Form::text("label[".$language->iso6391."]", null, [
                            'class'       => 'form-control input',
                            'placeholder' => "niño",
                            'required'    => 'required',
                            'form'        => 'create_subtype_form'
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
                'form'       => 'create_subtype_form'
            ]) !!}
        </div>
    </div>

{!!Form::close()!!}
