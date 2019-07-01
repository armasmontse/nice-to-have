{!! Form::open([
    'method'                => 'PATCH',
    'route'                 => ['admin::subtypes.ajax.update', '&#123;&#123;subtype.id&#125;&#125;'],
    'role'                  => 'form' ,
    'id'                    => 'update_subtype-&#123;&#123;subtype.id&#125;&#125;_form',
    'v-for'                 => "subtype in list",
    'v-if'                  => 'editIndex == $index',
    'data-index'            => '&#123;&#123;$index&#125;&#125;',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="col-xs-8">
        <div class="row">
            <div class="col-xs-9">
                <div class="form-group">
                    <div class="input__select-container">
                        <select class="form-control input__select"
                                required="required"
                                form="update_subtype-&#123;&#123;subtype.id&#125;&#125;_form"
                                name="type_id"
                                v-model="subtype.type_id">
                            <option value="" disabled="disabled">Tipo de evento</option>
                            <option :value="type.id" v-for="type in types">&#123;&#123; type.{{ $current_lang_iso }}_label&#125;&#125;</option>
                        </select>
                        <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                    </div>
                </div>
            </div>
            <div class="col-xs-3">
                <div class="form-group">
                    {!! Form::number("order", null, [
                        'class'       => 'form-control input',
                        'placeholder' => "number",
                        'required'    => 'required',
                        'step'        => 1,
                        "min"         => 0,
                        'form'        => 'update_subtype-&#123;&#123;subtype.id&#125;&#125;_form',
                        'v-model'     => 'subtype.order'
                    ]) !!}
                </div>
            </div>
            @foreach($languages as $language)
                <div class="col-xs-12">
                    <div class="form-group">
                        {!! Form::text("label"."[".$language->iso6391."]", null, [
                            'class'         => 'form-control input',
                            'required'      => 'required',
                            'placeholder'   => "Nombre",
                            'form'          => 'update_subtype-&#123;&#123;subtype.id&#125;&#125;_form',
                            'v-model'       => 'subtype.'.$language->iso6391.'_label'
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
                'form'   => 'update_subtype-&#123;&#123;subtype.id&#125;&#125;_form'
            ]) !!}
        </div>
    </div>

{!! Form::close() !!}
