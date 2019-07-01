@extends('layouts.modal',["modal_id"=> "product-section-create"])

@section('modal-title')
    Agregar seccion
@overwrite

@section('modal-content')
<product-sections-modal-create :list.sync="store.sections.data"></product-sections-modal-create>
<script type="x/templates"  id="product-sections-modal-create-template">
    {!! Form::open([
        'method'                => 'POST',
        'route'                 => ['admin::products.secciones.ajax.store',$product_edit->id],
        'role'                  => 'form' ,
        'id'                    => 'create_product-seccion_form',
        'class'                 => 'row',
        'v-on:submit.prevent'   => 'post'
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
                                    'form'          => 'create_product-seccion_form',
                                    "rows"          => 2,
                                    'placeholder'   =>  "Agregar título de la sección"
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
                            'form'          => 'create_product-seccion_form',
                            'min'           => '1',
                            'step'          => '1',
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
                                    'form'          => 'create_product-seccion_form',
                                    "rows"          => 2,
                                    'placeholder'   =>  "Agregar contenido de la sección"
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
                    'form'       => 'create_product-seccion_form'
                ]) !!}
            </div>
        </div>

    {!!Form::close()!!}

</script>
@overwrite
