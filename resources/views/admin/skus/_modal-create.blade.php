@extends('layouts.modal',["modal_id"=> "sku-create"])

@section('modal-title')
    Crear sku
@overwrite

@section('modal-content')

<product-skus-modal-create :list.sync="store.skus.data"></product-skus-modal-create>

<script type="x/templates" id="product-skus-modal-create-template">
    <div>
        {!! Form::open([
            'method'                => 'POST',
            'route'                 => ['admin::products.skus.ajax.store',$product_edit->id],
            'role'                  => 'form' ,
            'id'                    => 'create_sku_form',
            'class'                 => 'row',
            'v-on:submit.prevent'   => 'post'
        ]) !!}
            <div class="col-xs-11 col-xs-offset-1">
                <div class="row">
                    <div class="col-xs-9">
                        <div class="row">
                            <div class="col-xs-6">
                                <div class="form-group">
                                    {!! Form::label("price", 'Precio', ['class' => 'input-label']) !!}
                                    {!! Form::number("price", null, [
                                        'class'         => 'form-control input',
                                        'placeholder'   => "0.00",
                                        'required'      => 'required',
                                        'form'          => 'create_sku_form',
                                        'min'           => '1',
                                        'step'          => '0.01'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    {!! Form::label("discount", 'Porcentaje de descuento', ['class' => 'input-label']) !!}
                                    {!! Form::number("discount", null, [
                                        'class'         => 'form-control input',
                                        'placeholder'   => "10",
                                        'required'      => 'required',
                                        'form'          => 'create_sku_form',
                                        'min'           => '0',
                                        'step'          => '1',
                                        'max'           => '100'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    {!! Form::label("local_shipping_rate", 'Envío local', ['class' => 'input-label']) !!}
                                    {!! Form::number("local_shipping_rate", null, [
                                        'class'         => 'form-control input',
                                        'placeholder'   => "0.00",
                                        'required'      => 'required',
                                        'form'          => 'create_sku_form',
                                        'min'           => '0',
                                        'step'          => '0.01'
                                    ]) !!}
                                </div>
                            </div>
                            <div class="col-xs-6">
                                <div class="form-group">
                                    {!! Form::label("national_shipping_rate", 'Envío nacional', ['class' => 'input-label']) !!}
                                    {!! Form::number("national_shipping_rate", null, [
                                        'class'         => 'form-control input',
                                        'placeholder'   => "0.00",
                                        'required'      => 'required',
                                        'form'          => 'create_sku_form',
                                        'min'           => '0',
                                        'step'          => '0.01'
                                    ]) !!}
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-xs-3">
                        <div class="form-group">
                            <label for="default" class="input-label">
                                Principal
                                <br>
                                {!! Form::checkbox('default', true, null, [
                                    'id'    => 'default',
                                    'class' => 'input__checkbox',
                                ]) !!}
                            </label>
                        </div>
                    </div>
                    @foreach ($languages as $language)
                        <div class="col-xs-12">
                            <div class="form-group">
                                {!! Form::label("description[".$language->iso6391."]", "Descripción", ['class' => 'input-label']) !!}
                                {!! Form::textarea("description[".$language->iso6391."]", null , [
                                    'class'         => 'form-control input',
                                    'required'      => 'required',
                                    'form'          => 'create_sku_form',
                                    "rows"          => 2,
                                    'placeholder'   =>  "Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam..."
                                    ]) !!}
                            </div>
                        </div>
                    @endforeach
                    <div class="col-xs-12">
                        <div class="btn-group pull-right">
                            {!! Form::submit('Guardar', [
                                'class'      => 'btn btn-info button',
                                'form'       => 'create_sku_form'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        {!!Form::close()!!}
    </div>
</script>

@overwrite
