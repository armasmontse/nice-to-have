<div class="row row-mt">
    {!! Form::open([

        'method'                => "POST",
        'route'                 => ['admin::pages.sections.ajax.components.store','&#123;&#123;section.id&#125;&#125;'],
        'role'                  => 'form' ,
        'id'                    => '&#123;&#123;"create_component_"+section.index+"_form"&#125;&#125;',
        // 'v-if'                  => 'section.type.unlimited',
        'v-on:submit.prevent'  => 'post'
        ]) !!}
        <div class="row row-mt">
            <div class="col-xs-12">
                <div class="pull-right pageslists--save-button">
                    {!! Form::submit("Agregar", [
                        'class' => 'btn waves-effect waves-light',
                        'form'  => '&#123;&#123;"create_component_"+section.index+"_form"&#125;&#125;'
                    ]) !!}
                </div>
            </div>
        </div>
        <br>
        <br>
    {!! Form::close() !!}
</div>
