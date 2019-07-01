{!! Form::open([
    'method'                => 'PATCH',
    'route'                 => ['admin::categories.ajax.update', '&#123;&#123;category.id&#125;&#125;'],
    'role'                  => 'form' ,
    'id'                    => 'update_category-&#123;&#123;category.id&#125;&#125;_form',
    'v-for'                 => "category in list",
    'v-if'                  => 'editIndex == $index',
    'data-index'            => '&#123;&#123;$index&#125;&#125;',
    'v-on:submit.prevent'   => 'post'
]) !!}

    <div class="col-xs-2">
        <div class="form-group">
            {!! Form::number("order", null, [
                'class'       => 'form-control input',
                'placeholder' => "Orden",
                'required'    => 'required',
                'step'        => 1,
                "min"         => 0,
                'form'        => 'update_category-&#123;&#123;category.id&#125;&#125;_form',
                'v-model'     => 'category.order'
            ]) !!}
        </div>
    </div>

    <div class="col-xs-6">
        @foreach($languages as $language)
            <div class="form-group">
                {!! Form::text("label"."[".$language->iso6391."]", null, [
                    'class'         => 'form-control input',
                    'required'      => 'required',
                    'placeholder'   => "Nombre",
                    'form'          => 'update_category-&#123;&#123;category.id&#125;&#125;_form',
                    'v-model'       => 'category.'.$language->iso6391.'_label'
                ]) !!}
            </div>
        @endforeach
    </div>


    <div class="col-xs-3">
        <div class="btn-group pull-right">
            {!! Form::submit('actualizar', [
                'class'  => 'btn btn-info button',
                'form'   => 'update_category-&#123;&#123;category.id&#125;&#125;_form'
            ]) !!}
        </div>
    </div>


{!! Form::close() !!}
