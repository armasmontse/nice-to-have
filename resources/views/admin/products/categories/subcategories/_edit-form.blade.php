{!! Form::open([
    'method'                => 'PATCH',
    'route'                 => ['admin::subcategories.ajax.update', '&#123;&#123;subcategory.id&#125;&#125;'],
    'role'                  => 'form' ,
    'id'                    => 'update_subcategory-&#123;&#123;subcategory.id&#125;&#125;_form',
    'v-for'                 => "subcategory in list",
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
                                form="update_subcategory-&#123;&#123;subcategory.id&#125;&#125;_form"
                                name="category_id"
                                v-model="subcategory.category_id">
                            <option value="" disabled="disabled">Categoría</option>
                            <option :value="category.id" v-for="category in categories">&#123;&#123; category.{{ $current_lang_iso }}_label&#125;&#125;</option>
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
                        'form'        => 'update_subcategory-&#123;&#123;subcategory.id&#125;&#125;_form',
                        'v-model'     => 'subcategory.order'
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
                            'form'          => 'update_subcategory-&#123;&#123;subcategory.id&#125;&#125;_form',
                            'v-model'       => 'subcategory.'.$language->iso6391.'_label'
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
                'form'   => 'update_subcategory-&#123;&#123;subcategory.id&#125;&#125;_form'
            ]) !!}
        </div>
    </div>


{!! Form::close() !!}
