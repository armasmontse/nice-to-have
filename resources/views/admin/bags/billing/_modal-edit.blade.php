@extends('layouts.modal', ["modal_id"=> "billing-edit"])

@section('modal-title')
    Editar estatus de factura
@overwrite

@section('modal-content')

    <billing-modal-edit :list.sync="store.bags.data" :edit-index="0"></billing-modal-edit>

    <script type="x/templates" id="billing-modal-edit-template">
        <div>
            {!! Form::open([
                'method'                => 'PATCH',
                'route'                 => ['admin::bags.billing.ajax.update', '&#123;&#123;bag.key&#125;&#125;'],
                'role'                  => 'form' ,
                'id'                    => 'update_billing-&#123;&#123;bag.key&#125;&#125;_form',
                'v-for'                 => "bag in list",
                'v-if'                  => 'editIndex == $index && bag.bag_billing && bag.bag_status.paid',
                'data-index'            => '&#123;&#123;$index&#125;&#125;',
                'v-on:submit.prevent'   => 'post',
            ]) !!}

                <div class="row">

                    <div class="col-xs-12">

                        <h2 style="font-size: 22px;font-weight: 700;margin-bottom: 2em;text-transform: uppercase;text-align: center;">Pedido #@{{ bag.key }}</h2>

                        <h3 class="text__subtitle text__subtitle--no-margin">Información fiscal</h3>

                        <br><br>

                        <div class="form-group">
                            <label class="input-label">RFC</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.rfc">
                        </div>

                        <div class="form-group">
                            <label class="input-label">Razón social</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.razon_social">
                        </div>

                        <div class="form-group">
                            <label class="input-label">Info extra</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.info">
                        </div>

                        <br>

                        <h3 class="text__subtitle text__subtitle--no-margin">Domicilio fiscal</h3>

                        <br><br>

                        <div class="form-group">
                            <label class="input-label">Calle y número</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.address.street1">
                        </div>

                        <div class="form-group">
                            <label class="input-label">Colonia</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.address.street2">
                        </div>

                        <div class="form-group">
                            <label class="input-label">Delegación</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.address.street3">
                        </div>

                        <div class="form-group">
                            <label class="input-label">País</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.address.country.iso3166">
                        </div>

                        <div class="form-group">
                            <label class="input-label">Estado</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.address.state">
                        </div>

                        <div class="form-group">
                            <label class="input-label">Ciudad</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.address.city">
                        </div>

                        <div class="form-group">
                            <label class="input-label">Código postal</label>
                            <input class="form-control input" type="text" disabled="disabled" v-model="bag.bag_billing.address.zip">
                        </div>

                        <br>

                        <h3 class="text__subtitle text__subtitle--no-margin">Estatus de la factura</h3>

                        <br><br>

                        <div class="form-group">
                            <label class="input-label">Estatus de la factura</label>
                            <input class="form-control input" type="text" name="billing_status" placeholder="Estatus" form="update_billing-&#123;&#123;bag.key&#125;&#125;_form" v-model="bag.bag_billing.status">
                        </div>

                        <br><br>

                        {!! Form::submit('actualizar', [
                            'class'  => 'btn btn-info button',
                            'form'   => 'update_billing-&#123;&#123;bag.key&#125;&#125;_form'
                        ]) !!}

                    </div>

                </div>

            {!! Form::close() !!}

        </div>
    </script>

@overwrite
