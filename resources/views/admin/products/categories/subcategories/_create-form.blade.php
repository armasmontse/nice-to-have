{!! Form::open([
    'method'                => 'POST',
    'route'                 => ['admin::subcategories.ajax.store'],
    'role'                  => 'form' ,
    'id'                    => 'create_subcategory_form',
    'class'                 => 'row',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="col-xs-8 col-xs-offset-1">
        <div class="row">
            <div class="col-xs-9">
                <div class="form-group">
                    {!! Form::label('category_id', 'Categoría', ['class' => 'input-label']) !!}
                    <div class="input__select-container">
                        <select class="form-control input__select"
                                required="required"
                                form="create_subcategory_form"
                                name="category_id"
                                id="category_id">
                            <option value="" selected="selected" disabled="disabled">Seleccionar</option>
                            <option :value="category.id" v-for="category in categories">&#123;&#123; category.{{ $current_lang_iso }}_label&#125;&#125;</option>
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
                        'form'        => 'create_subcategory_form'
                    ]) !!}
                </div>
            </div>
            @foreach($languages as $language)
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::label("label[".$language->iso6391."]", 'Nombre:', ['class' => 'input-label']) !!}
                        {!! Form::text("label[".$language->iso6391."]", null, [
                            'class'       => 'form-control input',
                            'placeholder' => "Almohadas",
                            'required'    => 'required',
                            'form'        => 'create_subcategory_form'
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
                'form'       => 'create_subcategory_form'
            ]) !!}
        </div>
    </div>

{!!Form::close()!!}
