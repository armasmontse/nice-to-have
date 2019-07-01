@extends('layouts.modal', ["modal_id"=> "bag-status-edit"])

@section('modal-title')
    Editar estatus del carrito
@overwrite

@section('modal-content')

    <bag-status-modal-edit :list.sync="store.bags.data" :edit-index="0" bag-status='{!! json_encode($bags_status) !!}'></bag-status-modal-edit>

    <script type="x/templates" id="bag-status-modal-edit-template">

        <div>
                {!! Form::open([
                    'method'                => 'PATCH',
                    'route'                 => ['admin::bags.status.ajax.update', '&#123;&#123;bag.key&#125;&#125;'],
                    'role'                  => 'form' ,
                    'id'                    => 'update_status-&#123;&#123;bag.key&#125;&#125;_form',
                    'v-for'                 => "bag in list",
                    'v-if'                  => 'editIndex == $index && bag.bag_status.paid',
                    'data-index'            => '&#123;&#123;$index&#125;&#125;',
                    'v-on:submit.prevent'   => 'post',
                ]) !!}

                    <div class="row">

                        <div class="col-xs-12">

                            <h2 style="font-size: 22px;font-weight: 700;margin-bottom: 2em;text-transform: uppercase;text-align: center;">Pedido #@{{ bag.key }}</h2>

                            <h3 class="text__subtitle text__subtitle--no-margin">Estatus del pedido</h3>

                            <br>

                            <div class="form-group">
                                <label class="input-label">Estatus del carrito</label>
                                <div class="input__select-container">
                                    <select class="form-control input__select" name="status_id" required="required" form="update_status-&#123;&#123;bag.key&#125;&#125;_form" v-model="bag.bag_status_id">
                                        <option value="" disabled>Estatus</option>
                                        <option v-for="status in statusEncoded" v-bind:value="status.id" v-text="status.label"></option>
                                    </select>
                                    <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                                </div>
                            </div>

                            <div class="form-group">
                                <label class="input-label">Estatus info</label>
                                <textarea class="form-control input" name="status_info" rows="8" cols="80" form="update_status-&#123;&#123;bag.key&#125;&#125;_form" v-model="bag.status_info"></textarea>
                            </div>

                            {!! Form::submit('actualizar', [
                                'class'  => 'btn btn-info button',
                                'form'   => 'update_status-&#123;&#123;bag.key&#125;&#125;_form'
                            ]) !!}

                            {{-- <div v-if="bag.bag_status.paid && !bag.bag_status.cancel && (!bag.bag_type.event || (bag.bag_type.special && !bag.bag_type.protected))">

                                <h1>Hello world!</h1>

                            </div> --}}

                        </div>

                    </div>

                {!! Form::close() !!}

                {!! Form::open([
                    'method'                => 'PATCH',
                    'route'                 => ['admin::bags.shipping.ajax.update', '&#123;&#123;bag.key&#125;&#125;'],
                    'role'                  => 'form' ,
                    'id'                    => 'update_shipping-&#123;&#123;bag.key&#125;&#125;_form',
                    'v-for'                 => "bag in list",
                    'v-if'                  => 'editIndex == $index && bag.bag_status.paid && !bag.bag_status.cancel && (!bag.bag_type.event || (bag.bag_type.special && !bag.bag_type.protected))',
                    'data-index'            => '&#123;&#123;$index&#125;&#125;',
                    'v-on:submit.prevent'   => 'post',
                ]) !!}

                    <br><br>

                    <h3 class="text__subtitle text__subtitle--no-margin">Envío</h3>

                    <br>

                    <div class="form-group">
                        <label class="input-label">Tracking code</label>
                        <input class="form-control input" type="text" name="shipping_tracking_code" placeholder="Tracking code" v-model="bag.bag_shipping.tracking_code" form="update_shipping-&#123;&#123;bag.key&#125;&#125;_form">
                    </div>

                    <div class="form-group">
                        <label class="input-label">Shipping method</label>
                        <input class="form-control input" type="text" name="shipping_method" placeholder="Método de envío" v-model="bag.bag_shipping.method" form="update_shipping-&#123;&#123;bag.key&#125;&#125;_form">
                    </div>

                    <div class="form-group">
                        <label class="input-label">Shipping info</label>
                        <textarea class="form-control input" name="shipping_info" rows="8" cols="80" v-model="bag.bag_shipping.info" form="update_shipping-&#123;&#123;bag.key&#125;&#125;_form"></textarea>
                    </div>

                    {!! Form::submit('actualizar', [
                        'class'  => 'btn btn-info button',
                        'form'   => 'update_shipping-&#123;&#123;bag.key&#125;&#125;_form'
                    ]) !!}

                {!! Form::close() !!}

        </div>
    </script>

@overwrite
