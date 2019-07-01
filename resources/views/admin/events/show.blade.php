@extends('layouts.admin')

@section('title')
    Detalles del Evento | {{ $event->name }}
@endsection

@section('h1')
    Detalles del Evento: {{ $event->key }}
@endsection

@section('content')

    <div class="row">

        <div class="col-xs-10 col-xs-offset-1" style="margin-bottom: 40px;">

            @if ($event->user)
                @include('admin.general._page-instructions', [ 'title' => 'Datos del usuario:', 'instructions' => '' ])

            	<div class="row userEvent__columns">
            		<div class="col-xs-12">
            			<div class="userEvent__box">
            				<div class="flex-cont--sb mb2m">
            					<div>
            						<p class="userEvent__title tal">Nombre:</p>
            					</div>
            					<p class="userEvent--number userEvent__title--no-wrap">{{ $event->user->full_name }}</p>
            				</div>
                            <div class="flex-cont--sb mb2m">
                                <div>
                                    <p class="userEvent__title tal">Email:</p>
                                </div>
                                <p class="userEvent--number userEvent__title--no-wrap">{{ $event->user->email }}</p>
                            </div>
                            <div class="flex-cont--sb mb2m">
                                <div>
                                    <p class="userEvent__title tal">Teléfono:</p>
                                </div>
                                <p class="userEvent--number userEvent__title--no-wrap">{{ $event->user->phone }}</p>
                            </div>

                            @unless ($event->user->bank_accounts->isEmpty())
                                <div class="flex-cont--sb mb2m">
                                    <div>
                                        <p class="userEvent__title tal">Cuentas bancarias:</p>
                                    </div>
                                    <p class="userEvent--number userEvent__title--no-wrap">
                                        @foreach ($event->user->bank_accounts as $bank_account)
                                            <span class="">
                                                NOMBRE: {{ $bank_account->name }}<br>
                                                BANCO: {{ $bank_account->bank }}<br>
                                                SURCURSAL: {{ $bank_account->branch }}<br>
                                                CUENTA: {{ $bank_account->account_number }}<br>
                                                CLABE: {{ $bank_account->displayCLABE() }}
                                            </span>
                                            <br><br>
                                        @endforeach
                                    </p>
                                </div>
                            @endunless

            			</div>
            		</div>
            	</div>
            @endif

            @if ($event_address)
                @include('admin.general._page-instructions', [ 'title' => 'Dirección provincial del envió:', 'instructions' => 'Esta dirección puede no coincidir con la cual el usuario solicitara sus regalos una vez que realice el pago de su bolsa "Mi mesa de regalos"' ])

                <div class="row userEvent__columns">
                    <div class="col-xs-12">
                        <div class="userEvent__box">
                            <div class="flex-cont--sb mb2m">
                                <div>
                                    <p class="userEvent__title tal">Dirección:</p>
                                </div>
                                <p class="userEvent--number userEvent__title--no-wrap">{{$event_address->street1  }}, {{$event_address->street3  }}, {{$event_address->street2  }}, {{$event_address->city  }}, {{$event_address->state  }}, {{$event_address->country->official_name  }}, {{$event_address->zip  }}
                                @if ($event_address->references)
                                    <br> Referencias:  <span class=""> {{ $event_address->references  }} </span>
                                @endif
                                </p>
                            </div>
                            <div class="flex-cont--sb mb2m">
                                <div>
                                    <p class="userEvent__title tal">Email de contacto:</p>
                                </div>
                                <p class="userEvent--number userEvent__title--no-wrap">{{ $event_address->email }}</p>
                            </div>
                            <div class="flex-cont--sb mb2m">
                                <div>
                                    <p class="userEvent__title tal">Teléfono de contacto:</p>
                                </div>
                                <p class="userEvent--number userEvent__title--no-wrap">{{ $event_address->phone }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            @endif


            @include('admin.general._page-instructions', [ 'title' => 'Resumen de cuentas:', 'instructions' => '' ])

        	<div class="row userEvent__columns">
        		<div class="col-xs-6 userEvent__col-1-2">
        			<div class="userEvent__box">
        				<div class="flex-cont--sb mb2m">
        					<div>
        						<p class="userEvent__title tal">Total de regalos recibidos:</p>
        						<p class="userEvent__paragraph tal">Total en pesos de los productos <br>regalados (incluyendo IVA).</p>
        					</div>
        					<p class="userEvent--number userEvent__title--no-wrap">$ {{ number_format($event->current_protected_bag_value, 2, '.', ',') }}</p>
        				</div>
        				<div class="flex-cont--sb mb2m">
        					<div>
        						<p class="userEvent__title tal">Mínimo en productos:</p>
        						<p class="userEvent__paragraph tal">Cantidad mínima para realizar <br>pedido de productos NICE TO HAVE. <br>Incluye envíos en área metropolitana.</p>
        					</div>
        					<p class="userEvent--number tal userEvent__title--no-wrap">$ {{ number_format($event->current_checkout_min, 2, '.', ',') }}</p>
        				</div>
        				<div class="flex-cont--sb mb2m">
        					<div>
        						<p class="userEvent__title tal">Máximo en efectivo:</p>
        						<p class="userEvent__paragraph tal">Cantidad máxima de efectivo, {{ $percentage }}%<br>de los regalos.
        					</div>
        					<p class="userEvent--number tal userEvent__title--no-wrap">$ {{ number_format($event->current_cashouts_max, 2, '.', ',') }}</p>
        				</div>
        			</div>
        		</div>
        		<div class="col-xs-6 userEvent__col-2-2">
        			<div class="userEvent__box">
        				<div class="flex-cont--sb mb2m">
        					<div>
        						<p class="userEvent__title tal">Saldo:</p>
        						<p class="userEvent__paragraph tal">Saldo de regalos recibidos al <br>momento menos retiros.
        					</div>
        					<p class="userEvent--number userEvent__title--no-wrap">$ {{ number_format($event->current_total, 2, '.', ',') }}</p>
        				</div>
        			</div>
        		</div>
        	</div>

            @include('admin.general._page-instructions', [ 'title' => 'Información general', 'instructions' => 'Edita el producto. Da click en el enlace para ir al single del producto.' ])

            <div>
                <h2 class="text__subtitle text__subtitle--no-margin"><strong>{{ $event->name }}</strong></h2>
                @if ($event->is_publish)
                    <a href="{{ $event->public_url }}" class="link-underline">Ver web del evento</a>
                @endif
                <br>
            </div>

            @if (isset($event->typeable->type))
                <div class="form-group">
                    <label for="publish_date" class="input-label">Tipo de evento:</label>
                    <input type="text" name="" disabled="disabled" value="{{ $event->typeable->type->label }}" class="form-control input">
                </div>
            @endif

            <div class="form-group">
                <label for="publish_date" class="input-label">@if (isset($event->typeable->type)) Variación de evento: @else Tipo @endif</label>
                <input type="text" name="" disabled="disabled" value="{{ $event->typeable->label }}" class="form-control input">
            </div>

            <div class="form-group">
                <label for="publish_date" class="input-label">Nombre:</label>
                <input type="text" name="" disabled="disabled" value="{{ $event->name }}" class="form-control input">
            </div>

            <div class="form-group">
                <label for="publish_date" class="input-label">URL:</label>
                <input type="text" name="" disabled="disabled" value="{{ $event->public_url }}" class="form-control input">
            </div>

            <div class="form-group">
                <label for="publish_date" class="input-label">Festejados:</label>
                <input type="text" name="" disabled="disabled" value="{{ $event->feted_names }}" class="form-control input">
            </div>

            <div class="form-group">
                <label for="publish_date" class="input-label">Fecha del evento:</label>
                <input type="date" name="" disabled="disabled" value="{{ $event->date->format("Y-m-d") }}" class="form-control input">
                <input type="time" name="" disabled="disabled" value="{{ $event->date->format("H:m") }}" class="form-control input">
                <input type="text" name="" disabled="disabled" value="{{ $event->timezone }}" class="form-control input">
            </div>

        </div>

        <div class="col-xs-12">
            <h1 class="page-header content__header-title">Exclusividad del evento</h1>
        </div>

        <div class="col-xs-10 col-xs-offset-1" style="margin-bottom: 40px;">

            {!! Form::open([
                'method'    => 'PATCH',
                'route'     => ['admin::events.update', $event->id],
                'role'      => 'form',
                'id'        => 'edit_event_form'
            ]) !!}

                {!! Form::label('exclusive', 'Exclusividad:', [
                    'class' => 'input-label active admin-label '
                ]) !!}

                <div class="input__select-container">
                    {!! Form::select('exclusive', [0 => 'Tengo más mesas de regalos', 1 => 'Mesa de regalos única'], $event->exclusive, [
                        'class'         => 'form-control input__select',
                        'required'      => 'required',
                        'form'          => 'edit_event_form'
                    ])  !!}
                    <span class="fa fa-angle-down input__select-arrow" aria-hidden="true"></span>
                </div>

                <div class="row row-mt">
                    <div class="col-md-11 col-md-offset-1">
                        <div class="pull-right">
                            {!! Form::submit("Guardar", [
                                'class' => 'btn btn-info button pull-right',
                                'form'  => 'edit_event_form'
                            ]) !!}
                        </div>
                    </div>
                </div>

            {!! Form::close() !!}

        </div>

        <div class="col-xs-12">
            <h1 class="page-header content__header-title">Regalos del evento</h1>
        </div>

        <div class="col-xs-10 col-xs-offset-1" style="margin-bottom: 40px;">

            @forelse ($bags as $bag)

                @include('admin.general._page-instructions', [
                    'title' => '<a href="'. route('admin::bags.show', $bag->key) .'" target="_blank">BOLSA: ' . $bag->key . '</a>',
                    'instructions' => '<strong>Fecha de compra:</strong> ' . $bag->purshased_at->format('d/m/y') . '<br><strong>Estatus:</strong> ' . $bag->bagStatus->label
                ])

                <table class="table">
                    <thead class="text__p text__p-table-head">
                        <tr>
                            <th>&nbsp;</th>
                            <th>SKU</th>
                            <th>Nombre</th>
                            <th>Descripción</th>
                            <th>Precio</th>
                            <th>Cantidad</th>
                            <th>Descuento</th>
                            <th>Precio total</th>
                            <th>Regalo de</th>
                        </tr>
                    </thead>
                    <tbody class="text__p">
                        @foreach ($bag->skus as $sku)
                            <tr class="">
                                <td>
                                    <img src="{{ $sku->thumbnail_image->url }}" alt="" style="min-width: 52px;">
                                </td>
                                <td>
                                    <a href="{{ $sku->product->client_url }}" target="_blank">{{ $sku->sku }}</a>
                                </td>
                                <td>
                                    <a href="{{ $sku->product->client_url }}" target="_blank">{{ $sku->product->title }}</a>
                                </td>
                                <td>
                                    {{ $sku->description }}
                                </td>
                                <td>
                                    ${{ number_format($sku->pivot->price * (1-$sku->pivot->discount/100), 2, '.', ',') }}
                                </td>
                                <td>
                                    {{ $sku->pivot->quantity }}
                                </td>
                                <td>
                                    {{ $sku->pivot->discount }}%
                                </td>
                                <td>
                                    ${{ number_format($sku->pivot->price * (1-$sku->pivot->discount/100) * $sku->pivot->quantity, 2, '.', ',') }}
                                </td>
                                <td>
                                    {{ $bag->bagUser->name }} <br>
                                    {{ $bag->bagUser->email }} <br>
                                    {!! nl2br($bag->message) !!}
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>

            @empty

                <div class="text-center">
			        <p>No hay regalos registrados para este evento</p>
    			</div>

            @endforelse

        </div>

        <div class="col-xs-12">
            <h1 class="page-header content__header-title">Retiros en efectivo del evento</h1>
        </div>

        <div class="col-xs-10 col-xs-offset-1" style="margin-bottom: 40px;">

            @if($cashouts->isEmpty())
    			<div class="text-center">
			        <p>No hay retiros registrados para este evento</p>
    			</div>
            @else
                <cashouts :list="store.cashouts.data"></cashouts>
            @endif

        </div>

    </div>

    <script type="x/templates" id="cashouts-template">

        <table class="table">

            <thead class="text__p text__p-table-head">
                <tr>
                    <th>Retiro de efectivo</th>
                    <th>Comisión por retiro</th>
                    <th>Total de transferencia</th>
                    <th>Estatus de transferencia</th>
                    <th>Información bancaria</th>
                    <th>Fecha de solicitud</th>
                </tr>
            </thead>

            <tbody class="text__p">
                <tr v-for="cashout in list" v-bind:class="{ warning: !cashout.cash_out_status.apply && !cashout.cash_out_status.cancel }">
                    <td>
                        @{{ cashout.total | currency }}
                    </td>
                    <td>
                        @{{ cashout.fee_value | currency }} <br>
                        (@{{ cashout.fee }}%)
                    </td>
                    <td>
                        @{{ cashout.total_out | currency}}
                    </td>
                    <td>
                        @{{ cashout.cash_out_status.label }} <br>
                        <a href="#" data-toggle="modal" data-target="#cashout-status-edit" data-index="@{{$index}}" class="link-underline">
                            (Cambiar estatus)
                        </a>
                    </td>
                    <td>
                        Nombre: @{{ cashout.bank_account.name }} <br>
                        Banco: @{{ cashout.bank_account.bank }} <br>
                        Sucursal: @{{ cashout.bank_account.branch }} <br>
                        CLABE: @{{ cashout.bank_account.CLABE }} <br>
                        Número de cuenta: @{{ cashout.bank_account.account_number }} <br>
                    </td>
                    <td>
                        @{{ cashout.created_at }}
                    </td>
                </tr>
            </tbody>

        </table>

    </script>

@endsection

@section('modals')
    @include('admin.cashouts.status._modal-edit')
@endsection

@section('vue_store')
    <script>
        mainVueStore.cashouts = { data: {!! json_encode($cashouts) !!} };
    </script>
@endsection
