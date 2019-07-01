@extends('layouts.modal', ["modal_id"=> "cashout-status-edit"])

@section('modal-title')
    Editar estatus del retiro
@overwrite

@section('modal-content')

    <cashout-status-modal-edit :list.sync="store.cashouts.data" :edit-index="0" cashout-status='{!! json_encode($cashouts_status) !!}'></cashout-status-modal-edit>

    <script type="x/templates" id="cashout-status-modal-edit-template">

        <div>

            {!! Form::open([
                'method'                => 'PATCH',
                'route'                 => ['admin::cashouts.status.ajax.update', '&#123;&#123;cashout.id&#125;&#125;'],
                'role'                  => 'form' ,
                'id'                    => 'update_status-&#123;&#123;cashout.id&#125;&#125;_form',
                'v-for'                 => "cashout in list",
                'v-if'                  => 'editIndex == $index',
                'data-index'            => '&#123;&#123;$index&#125;&#125;',
                'v-on:submit.prevent'   => 'post',
            ]) !!}

                <div class="row">

                    <div class="col-xs-12">

                        <h2 style="font-size: 22px;font-weight: 700;margin-bottom: 2em;text-transform: uppercase;text-align: center;">Retiro efectivo evento: @{{ cashout.event.name }}</h2>

                        <h3 class="text__subtitle text__subtitle--no-margin">Información bancaria</h3>

                        <br><br>

                        Nombre: @{{ cashout.bank_account.name }} <br>
                        Banco: @{{ cashout.bank_account.bank }} <br>
                        Sucursal: @{{ cashout.bank_account.branch }} <br>
                        CLABE: @{{ cashout.bank_account.CLABE }} <br>
                        Número de cuenta: @{{ cashout.bank_account.account_number }} <br>

                        <br><br>

                        <h3 class="text__subtitle text__subtitle--no-margin">Estatus del pedido</h3>

                        <br>

                        <div class="form-group">
                            <label class="input-label">Estatus de la solicitud</label>
                            <div class="input__select-container">
                                <select class="form-control input__select" name="status_id" required="required" form="update_status-&#123;&#123;cashout.id&#125;&#125;_form" v-model="cashout.cash_out_status_id">
                                    <option value="" disabled>Estatus</option>
                                    <option v-for="status in statusEncoded" v-bind:value="status.id" v-text="status.label"></option>
                                </select>
                                <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                            </div>
                        </div>

                        <div class="form-group">
                            <label class="input-label">Estatus info</label>
                            <textarea class="form-control input" name="status_info" rows="8" cols="80" form="update_status-&#123;&#123;cashout.id&#125;&#125;_form" v-model="cashout.info"></textarea>
                        </div>

                        {!! Form::submit('actualizar', [
                            'class'  => 'btn btn-info button',
                            'form'   => 'update_status-&#123;&#123;cashout.id&#125;&#125;_form'
                        ]) !!}

                    </div>

                </div>

            {!! Form::close() !!}

        </div>

    </script>

@overwrite
