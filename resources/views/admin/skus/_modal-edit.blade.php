@extends('layouts.modal',["modal_id"=> "sku-edit"])

@section('modal-title')
    Editar sku
@overwrite

@section('modal-content')

<product-skus-modal-edit :list.sync="store.skus.data" :edit-index="0"></product-skus-modal-edit>

<script type="x/templates" id="product-skus-modal-edit-template">
    <div>
        {!! Form::open([
            'method'                => 'PATCH',
            'route'                 => ['admin::products.skus.ajax.update',$product_edit->id,'&#123;&#123;product_sku.sku&#125;&#125;'],
            'role'                  => 'form' ,
            'id'                    => 'update_product-sku-&#123;&#123;product_sku.sku&#125;&#125;_form',
            'class'                 => 'row',
            'v-for'                 => "product_sku in list",
            'v-if'                  => 'editIndex == $index',
            'data-index'            => '&#123;&#123;$index&#125;&#125;',
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
                                        'form'          => 'update_product-sku-&#123;&#123;product_sku.sku&#125;&#125;_form',
                                        'min'           => '1',
                                        'step'          => '0.01',
                                        'v-model'       => 'product_sku.price'
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
                                        'form'          => 'update_product-sku-&#123;&#123;product_sku.sku&#125;&#125;_form',
                                        'min'           => '0',
                                        'step'          => '1',
                                        'max'           => '100',
                                        'v-model'       => 'product_sku.discount'
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
                                        'form'          => 'update_product-sku-&#123;&#123;product_sku.sku&#125;&#125;_form',
                                        'min'           => '0',
                                        'step'          => '0.01',
                                        'v-model'       => 'product_sku.local_shipping_rate'
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
                                        'form'          => 'update_product-sku-&#123;&#123;product_sku.sku&#125;&#125;_form',
                                        'min'           => '0',
                                        'step'          => '0.01',
                                        'v-model'       => 'product_sku.national_shipping_rate'
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
                                    'id'         => 'default',
                                    'class'      => 'input__checkbox',
                                    'v-model'    => 'product_sku.default'
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
                                    'form'          => 'update_product-sku-&#123;&#123;product_sku.sku&#125;&#125;_form',
                                    "rows"          => 2,
                                    'placeholder'   =>  "Pellentesque habitant morbi tristique senectus et netus et malesuada fames ac turpis egestas. Vestibulum tortor quam...",
                                    'v-model'       => 'product_sku.'.$language->iso6391.'_description'
                                    ]) !!}
                            </div>
                        </div>
                    @endforeach
                    <div class="col-xs-12">
                        <div class="btn-group pull-right">
                            {!! Form::submit('Guardar', [
                                'class'      => 'btn btn-info button',
                                'form'       => 'update_product-sku-&#123;&#123;product_sku.sku&#125;&#125;_form'
                            ]) !!}
                        </div>
                    </div>
                </div>
            </div>
        {!!Form::close()!!}
    </div>
</script>

@overwrite
