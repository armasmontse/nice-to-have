{!! Form::open([
    'method'                => 'PATCH',
    'route'                 => ['admin::types.ajax.update', '&#123;&#123;type.id&#125;&#125;'],
    'role'                  => 'form' ,
    'id'                    => 'update_type-&#123;&#123;type.id&#125;&#125;_form',
    'v-for'                 => "type in list",
    'v-if'                  => 'editIndex == $index',
    'data-index'            => '&#123;&#123;$index&#125;&#125;',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="col-xs-8">
        <div class="row">
            <div class="col-xs-3">
                <div class="form-group">
                    {!! Form::number("order", null, [
                        'class'       => 'form-control input',
                        'placeholder' => "number",
                        'required'    => 'required',
                        'step'        => 1,
                        "min"         => 0,
                        'form'        => 'update_type-&#123;&#123;type.id&#125;&#125;_form',
                        'v-model'     => 'type.order'
                    ]) !!}
                </div>
            </div>
            @foreach($languages as $language)
                <div class="col-xs-9">
                    <div class="form-group">
                        {!! Form::text("label[".$language->iso6391."]", null, [
                            'class'       => 'form-control input',
                            'placeholder' => "Nombre",
                            'required'    => 'required',
                            'form'        => 'update_type-&#123;&#123;type.id&#125;&#125;_form',
                            'v-model'       => 'type.'.$language->iso6391.'_label'
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::text("title[".$language->iso6391."]", null, [
                            'class'       => 'form-control input',
                            'placeholder' => "Título",
                            // 'required'    => 'required',
                            'form'        => 'update_type-&#123;&#123;type.id&#125;&#125;_form',
                            'v-model'       => 'type.'.$language->iso6391.'_title'
                        ]) !!}
                    </div>
                </div>
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::textarea("description[".$language->iso6391."]", null, [
                            'class'       => 'form-control input',
                            'placeholder' => "Descripción",
                            // 'required'    => 'required',
                            'rows'         => '2',
                            'form'        => 'update_type-&#123;&#123;type.id&#125;&#125;_form',
                            'v-model'       => 'type.'.$language->iso6391.'_description'
                        ]) !!}
                    </div>
                </div>
            @endforeach
        </div>

    </div>


    <div class="col-xs-3">
        <div class="btn-group pull-right">
            {!! Form::submit('actualizar', [
                'class'  => 'btn btn-info button',
                'form'   => 'update_type-&#123;&#123;type.id&#125;&#125;_form'
            ]) !!}
        </div>
    </div>


{!! Form::close() !!}
