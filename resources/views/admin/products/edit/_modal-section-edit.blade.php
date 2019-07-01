@extends('layouts.modal',["modal_id"=> "product-section-edit"])

@section('modal-title')
    Editar sección
@overwrite

@section('modal-content')

<product-sections-modal-edit :list.sync="store.sections.data" :edit-index="0"></product-sections-modal-edit>
<script type="x/templates"  id="product-sections-modal-edit-template">


    {!! Form::open([
        'method'                => 'PATCH',
        'route'                 => ['admin::products.secciones.ajax.update',$product_edit->id,'&#123;&#123;product_section.id&#125;&#125;'],
        'role'                  => 'form' ,
        'id'                    => 'update_product-seccion-&#123;&#123;product_section.id&#125;&#125;_form',
        'class'                 => 'row',
        'v-on:submit.prevent'   => 'post',
        'v-for'                 => "product_section in list",
        'v-if'                  => 'editIndex == $index',
        'data-index'            => '&#123;&#123;$index&#125;&#125;',
    ]) !!}
        <div class="col-xs-8 col-xs-offset-1">

            <div class="row">
                <div class="col-xs-9">
                    @foreach ($languages as $language)
                            <div class="form-group">
                                {!! Form::label("title[".$language->iso6391."]", "Título", ['class' => '']) !!}
                                {!! Form::text("title[".$language->iso6391."]", null , [
                                    'class'         => 'form-control',
                                    'required'      => 'required',
                                    'form'          => 'update_product-seccion-&#123;&#123;product_section.id&#125;&#125;_form',
                                    "rows"          => 2,
                                    'placeholder'   =>  "Pellentesque habitant morbi...",
                                    'v-model'       => 'product_section.'.$language->iso6391.'_title'
                                    ]) !!}
                            </div>
                    @endforeach
                </div>

                <div class="col-xs-3">
                    <div class="form-group">
                        {!! Form::label("order", 'Orden') !!}
                        {!! Form::number("order", null, [
                            'class'         => 'form-control',
                            'placeholder'   => "1",
                            'required'      => 'required',
                            'form'          => 'update_product-seccion-&#123;&#123;product_section.id&#125;&#125;_form',
                            'min'           => '1',
                            'step'          => '1',
                            'v-model'       => 'product_section.order'
                        ]) !!}
                    </div>
                </div>

                <div class="col-xs-12">
                    @foreach ($languages as $language)
                            <div class="form-group">
                                {!! Form::label("content[".$language->iso6391."]", "Contenido", ['class' => '']) !!}
                                {!! Form::textarea("content[".$language->iso6391."]", null , [
                                    'class'         => 'form-control',
                                    'required'      => 'required',
                                    'form'          => 'update_product-seccion-&#123;&#123;product_section.id&#125;&#125;_form',
                                    "rows"          => 2,
                                    'placeholder'   =>  "Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam...",
                                    'v-model'       => 'product_section.'.$language->iso6391.'_content'
                                    ]) !!}
                            </div>
                    @endforeach
                </div>
            </div>


        </div>
        <div class="col-xs-3">
            <div class="btn-group pull-right">
                {!! Form::submit('Guardar', [
                    'class'      => 'btn btn-info button',
                    'form'       => 'update_product-seccion-&#123;&#123;product_section.id&#125;&#125;_form'
                ]) !!}
            </div>
        </div>



    {!!Form::close()!!}
</script>
@overwrite
