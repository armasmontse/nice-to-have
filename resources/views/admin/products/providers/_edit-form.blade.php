{!! Form::open([
    'method'                => 'PATCH',
    'route'                 => ['admin::providers.ajax.update','&#123;&#123;provider.id&#125;&#125;'],
    'role'                  => 'form' ,
    'id'                    => 'update_provider-&#123;&#123;provider.id&#125;&#125;_form',
    'class'                 => '',
    'v-for'                 => "provider in list",
    'v-if'                  => 'editIndex == $index',
    'data-index'            => '&#123;&#123;$index&#125;&#125;',
    'v-on:submit.prevent'   => 'post'
]) !!}
    <div class="col-xs-8">
        <div class="form-group">
            {!! Form::text("label", null, [
                'class'         => 'form-control input',
                'placeholder'   => "Nombre(s)",
                'required'      => 'required',
                'form'          => 'update_provider-&#123;&#123;provider.id&#125;&#125;_form',
                'v-model'       => 'provider.label'
            ]) !!}
        </div>
    </div>

    <div class="col-xs-4">
        <div class="btn-group pull-right">
            {!! Form::submit('Actualizar', [
                'class'      => 'btn btn-info button',
                'form'       => 'update_provider-&#123;&#123;provider.id&#125;&#125;_form'
            ]) !!}
        </div>
    </div>

{!!Form::close()!!}
