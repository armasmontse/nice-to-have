@extends('layouts.modal', ['modal_id' => 'pagesections-modal-create'])

@section('modal-title')
    Agregar una seccion de página
@overwrite


@section('modal-content')

<pagesections-modal-create :list.sync="store.pagesections.data"></pagesections-modal-create>

<script type="x/templates" id="pagesections-modal-create-template">
    {!! Form::open([
        'method'                => 'POST',
        'route'                 => ['admin::pages.sections.ajax.store'],
        'role'                  => 'form' ,
        'id'                    => 'create_page_section_form',
        'class'                 => 'row',
        'v-on:submit.prevent'   => 'post'
        ]) !!}

        <div class="col-xs-12">
            {!! Form::label('index', "Nombre:", [
                'class' => 'input-label active',
            ]) !!}
            {!! Form::text('index', null, [
                'class'         => 'validate form-control input',
                'required'      => 'required',
                'form'          => 'create_page_section_form',
                'placeholder'   => 'home-slider'
            ]) !!}
        </div>

        <div class=" col-xs-12 row-mt">
            {!! Form::label('description',"Descripción:", [
                'class' => 'input-label active',
            ]) !!}
            <v-editor :content.sync='item_on_create.description'></v-editor>
            <input type="hidden" v-model="item_on_create.description" name="description">
        </div>

        <div class=" col-xs-12 row-mt">
            {!! Form::label('template_path',"Client template path:", [
                'class' => 'input-label active',
            ]) !!}
            {!! Form::text('template_path', null, [
                'class'         => 'validate form-control input',
                'required'      => 'required',
                'form'          => 'create_page_section_form',
                'placeholder'   => "home.slider"
            ]) !!}
        </div>

        <div class="col-xs-6  row-mt">
            {!! Form::label('components_max',"Número maximo de componentes:", [
                'class' => 'input-label active',
            ]) !!}
            {!! Form::number('components_max', null, [
                'min'           => 0,
                'step'          => 1,
                'class'         => 'validate form-control input',
                // 'required'      => 'required',
                'form'          => 'create_page_section_form',
                'placeholder'   => "3"
            ]) !!}
        </div>

        <div class="col-xs-6 row-mt">
            {!! Form::label("types-".'create_page_section_form', "Tipo:", [
                'class'         => 'input-label active',
            ]) !!}
            <div class="input__select-container">
                {!! Form::select('type_id', $types_list, null, [
                    'class'         => 'validate form-control input__select',
                    'required'      => 'required',
                    'placeholder'   => 'Seleccionar',
                    'form'          => 'create_page_section_form',
                    'id'            => 'types-' . 'create_page_section_form'
                ])  !!}
                <span class="fa fa-angle-down input__select-arrow" aria-hidden="false"></span>
            </div>
        </div>

        <div class="col-xs-12  row-mt">
            <h6>Partes editables por el usuario</h6>

            <div class="row">
                @foreach ($editable_parts as $part_key => $part_label)
                    <div class="col-xs-6 mt-checkbox">
                        {{ Form::checkbox('editable_contents['.$part_key.']', true, null, [
                            'class' => 'filled-in input__checkbox',
                            'id'    => 'editable_contents-'.$part_key.'-create_page_section_form',
                            'form'  => 'create_page_section_form',
                            ]) }}
                        {!! Form::label('editable_contents-'.$part_key.'-create_page_section_form', $part_label, [
                            'class' => 'input-label'
                        ]) !!}
                    </div>
                @endforeach
            </div>
            <br><br>
        </div>

        <div class="col-xs-12">
            <div class="pull-right">
                {!! Form::submit('Crear', [
                    'class'  => 'btn btn-info button',
                    'form'   => 'create_page_section_form'
                ]) !!}
            </div>
        </div>
    {!! Form::close() !!}

</script>

@overwrite
