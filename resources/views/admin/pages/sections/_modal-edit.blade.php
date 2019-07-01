@extends('layouts.modal', ['modal_id' => 'pagesections-modal-edit'])

@section('modal-title')
    Editar Sección
@overwrite

@section('modal-content')

<pagesections-modal-edit :list.sync="store.pagesections.data" :edit-index="0"></pagesections-modal-edit>

<script type="x/templates" id="pagesections-modal-edit-template">
    {!! Form::open([
        'method'                => 'PATCH',
        'route'                 => ['admin::pages.sections.ajax.update','&#123;&#123;pagesection.id&#125;&#125;'],
        'role'                  => 'form' ,
        'id'                    => 'update_page_section-&#123;&#123;pagesection.id&#125;&#125;_form',
        'v-for'                 => 'pagesection in list',
        'v-if'                  => 'editIndex == $index',
        'data-index'            => '&#123;&#123;$index&#125;&#125;',
        'class'                 => 'row',
        'v-on:submit.prevent'   => 'post'
        ]) !!}

        <div class="col-xs-6 col-xs-offset-6 row-mt">
            <strong>@{{{pagesection.type_label}}}</strong>
        </div>

        <div class=" col-xs-12">
            {!! Form::label('description',"Descripción:", [
                'class' => 'input-label active',
            ]) !!}
            <v-editor :content.sync='pagesection.description'></v-editor>
            <input type="hidden" v-model="pagesection.description" name="description">
        </div>

        <div class=" col-xs-12 row-mt">
            {!! Form::label('template_path',"Client template path:", [
                'class' => 'input-label active',
            ]) !!}
            {!! Form::text('template_path', null, [
                'v-model'       => 'pagesection.template_path',
                'class'         => 'validate form-control input',
                'required'      => 'required',
                'form'          => 'update_page_section-&#123;&#123;pagesection.id&#125;&#125;_form',
                'placeholder'   => "home.slider"
            ]) !!}
        </div>
        <div class="col-xs-12 row-mt" v-if="pagesection.type && !pagesection.type.protected && !pagesection.type.unlimited">
            {!! Form::label('components_max',"Número maximo de componentes:", [
                'class' => 'input-label active',
            ]) !!}
            {!! Form::number('components_max', null, [
                'v-model'       => 'pagesection.components_max',
                'min'           => 0,
                'step'          => 1,
                'class'         => 'validate form-control input text-center',
                'required'      => 'required',
                'form'          => 'update_page_section-&#123;&#123;pagesection.id&#125;&#125;_form',
                'placeholder'   => "3"
            ]) !!}
        </div>

        <div class="col-xs-12 row-mt" v-if="pagesection.type && !pagesection.type.protected ">
            <h6>Partes editables por el usuario</h6>

            <div class="row row-mt">
                @foreach ($editable_parts as $part_key => $part_label)
                    <div class="col-xs-6 mt-checkbox">
                        {{ Form::checkbox('editable_contents['.$part_key.']', true, null, [
                            'v-model'   => 'pagesection.editable_contents.'.$part_key,
                            'class'     => 'ffilled-in input__checkbox',
                            'id'        => 'editable_contents-'.$part_key.'-update_page_section-&#123;&#123;pagesection.id&#125;&#125;_form',
                            'form'      => 'update_page_section-&#123;&#123;pagesection.id&#125;&#125;_form',
                            ]) }}
                        {!! Form::label('editable_contents-'.$part_key.'-update_page_section-&#123;&#123;pagesection.id&#125;&#125;_form', $part_label, [
                            'class' => 'input-label'
                        ]) !!}
                    </div>
                @endforeach
            </div>
            <br><br>
        </div>

        <div class="col-xs-12 row-mt">
            <div class="pull-right">
                {!! Form::submit('Actualizar', [
                    'class'  => 'btn btn-info button',
                    'form'   => 'update_page_section-&#123;&#123;pagesection.id&#125;&#125;_form',
                ]) !!}
            </div>
        </div>

    {!! Form::close() !!}

</script>

@overwrite
