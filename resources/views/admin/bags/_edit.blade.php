@extends('layouts.admin')

@section('title')
    Editar Carrito | #{{ $bag->key }}
@overwrite

@section('h1')
    Editar Carrito #{{ $bag->key }}
@endsection

@section('content')

    {!! Form::open([
        'method'	=> 'PATCH',
        'route' 	=> ['admin::bags.status.update', $bag->key],
        'role'  	=> 'form',
        'id'    	=> 'update_status_bag_form'
    ]) !!}

        <div class="row">
            <div class="col-xs-12">
                <h2 style="font-size: 22px;font-weight: 700;margin-bottom: 2em;text-transform: uppercase;text-align: center;">Pedido #{{ $bag->key }}</h2>

                <h3 class="text__subtitle text__subtitle--no-margin">Estatus del pedido</h3>

                <br>

                <div class="form-group">
                    <label class="input-label">Estatus del carrito</label>
                    <div class="input__select-container">
                        {!! Form::select('status_id', $bags_status, $bag->bag_status_id, [
                            'class'         => 'form-control input__select',
                            'required'      => 'required',
                            'form'          => 'update_status_bag_form'
                        ])  !!}
                        <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                    </div>
                </div>

                <div class="form-group">
                    <label class="input-label">Información acerca del pedido</label>
                    <textarea class="form-control input" name="status_info" rows="8" cols="80" form="update_status_bag_form" placeholder=" Esta información sólo es para el control administrativo, ya que no aparecerá en la orden de compra del usuario. Aquí puede ir información más detallada acerca de este pedido, como alguna devolución de dinero, o que se haya pedido cambiar la dirección de envío.">{{ $bag->status_info or '' }}</textarea>
                </div>

                {!! Form::submit('actualizar', [
                    'class'  => 'btn btn-info button',
                    'form'   => 'update_status_bag_form'
                ]) !!}

            </div>
        </div>

    {!! Form::close() !!}

    @if ($bag->hasShipping())

        {!! Form::open([
            'method'	=> 'PATCH',
            'route' 	=> ['admin::bags.shipping.update', $bag->key],
            'role'  	=> 'form',
            'id'    	=> 'update_shipping_bag_form'
        ]) !!}

            <br><br>

            <h3 class="text__subtitle text__subtitle--no-margin">Envío</h3>

            <br>

            <div class="form-group">
                <label class="input-label">Número de guía</label>
                <input class="form-control input" type="text" name="shipping_tracking_code" placeholder="Número de guía" form="update_shipping_bag_form" value="{{ $bag->bagShipping->tracking_code }}">
            </div>

            <div class="form-group">
                <label class="input-label">Método de envío</label>
                <input class="form-control input" type="text" name="shipping_method" placeholder="Tipo de envío: estándar, express, nacional, internacional, etc." form="update_shipping_bag_form" value="{{ $bag->bagShipping->method }}">
            </div>

            <div class="form-group">
                <label class="input-label">Información acerca del envío</label>
                <textarea class="form-control input" name="shipping_info" rows="8" cols="80" form="update_shipping_bag_form" placeholder="Información visible para el usuario acerca del estatus de envío de su compra. Esta se mostrará en la orden de compra en el apartado de información de envío a lado de la etiqueta ESTATUS.">{{ $bag->bagShipping->info }}</textarea>
            </div>

            {!! Form::submit('actualizar', [
                'class'  => 'btn btn-info button',
                'form'   => 'update_shipping_bag_form'
            ]) !!}

        {!! Form::close() !!}

    @endif

    {{-- Si la bolsa no tiene registro en bag_billing no se muestra el formulario correspondiente --}}
    @if (!is_null($bag_billing))

	    {!! Form::open([
	        'method'	=> 'PATCH',
	        'route' 	=> ['admin::bags.billing.update', $bag->key],
	        'role'  	=> 'form',
	        'id'    	=> 'update_billing_bag_form'
	    ]) !!}

	    	<br><br>

	        <div class="row">
	            <div class="col-xs-12">

	                <h3 class="text__subtitle text__subtitle--no-margin">Información fiscal</h3>

	                <br><br>

	                <div class="form-group">
	                    <label class="input-label">RFC</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->rfc }}">
	                </div>

	                <div class="form-group">
	                    <label class="input-label">Razón social</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->razon_social }}">
	                </div>

	                <div class="form-group">
	                    <label class="input-label">Info extra</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->info }}">
	                </div>

	                <br>

	                <h3 class="text__subtitle text__subtitle--no-margin">Domicilio fiscal</h3>

	                <br><br>

	                <div class="form-group">
	                    <label class="input-label">Calle y número</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->address->street1 }}">
	                </div>

	                <div class="form-group">
	                    <label class="input-label">Colonia</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->address->street2 }}">
	                </div>

	                <div class="form-group">
	                    <label class="input-label">Delegación</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->address->street3 }}">
	                </div>

	                <div class="form-group">
	                    <label class="input-label">País</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->address->country->iso3166 }}">
	                </div>

	                <div class="form-group">
	                    <label class="input-label">Estado</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->address->state }}">
	                </div>

	                <div class="form-group">
	                    <label class="input-label">Ciudad</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->address->city }}">
	                </div>

	                <div class="form-group">
	                    <label class="input-label">Código postal</label>
	                    <input class="form-control input" type="text" disabled="disabled" value="{{ $bag_billing->address->zip }}">
	                </div>

	                <br>

	                <h3 class="text__subtitle text__subtitle--no-margin">Estatus de la factura</h3>

	                <br><br>

	                <div class="form-group">
	                    <label class="input-label">Estatus de la factura</label>
	                    <input class="form-control input" type="text" name="billing_status" placeholder="Estatus" form="update_billing_bag_form" value="{{ $bag_billing->status }}">
	                </div>

	                {!! Form::submit('actualizar', [
	                    'class'  => 'btn btn-info button',
	                    'form'   => 'update_billing_bag_form'
	                ]) !!}

	            </div>
	        </div>

	    {!! Form::close() !!}

    @endif

@endsection
