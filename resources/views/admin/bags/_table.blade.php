<table class="carts dataTable_JS table">

    <thead class="text__p text__p-table-head">
        <tr>
            <th class="carts--header carts--key">Key</th>
            <th class="carts--header carts--type">Tipo</th>
            <th class="carts--header carts--user">Usuario</th>
            <th class="carts--header carts--status">Estatus</th>
            <th class="carts--header carts--payment">Pago</th>
            <th class="carts--header carts--products">Fecha de compra</th>
            <th class="carts--header carts--billing text-center">Factura</th>
            <th class="carts--header carts--billing text-center" >Detalles</th>
            <th class="carts--header carts--billing text-center">Editar</th>
        </tr>
    </thead>

    <tbody class="text__p">
        @foreach ($bags as $bag)
            <tr>
                <td class="carts--cell carts--key">
                    #{{ $bag->key }}
                </td>
                <td class="carts--cell carts--type">
                    {{ $bag->bagType->label }} <br>
                    @if ($bag->bagType->event)
                        ({{ $bag->event->key }})
                    @endif
                </td>
                <td class="carts--cell carts--user">
                    @if ($bag->bagStatus->paid)
                        {{ $bag->bagUser->name }} <br>
                        ({{ $bag->bagUser->email }})
                    @elseif ($bag->bagUser->user)
                        {{ $bag->bagUser->user->full_name }} <br>
                        ({{ $bag->bagUser->user->email }})
                    @else
                        Usuario no registrado
                    @endif
                </td>
                <td class="carts--cell carts--status">
                    {{ $bag->bagStatus->label }}
                </td>
                <td class="carts--cell carts--payment text-center">
                    @if ($bag->bagStatus->paid && $bag->bagPayment)
    					{{ $bag->bagPayment->payable_type_label }}
                    @else
                        -
                    @endif
                </td>
                <td class="carts--cell carts--payment">
                    @if ($bag->bagStatus->paid && $bag->purshased_at)
                        {{ $bag->purshased_at->format('Y/m/d H:m') }}
                    @else
                        -
                    @endif
                </td>
                <td class="carts--cell carts--billing">
                    @if ($bag->bagStatus->paid && $bag->bag_billing)
                        {{ $bag->bagBilling->status }} <br>
                    @else
                        -
                    @endif
                </td>
                <td>
                    @if (!$bag->bagStatus->active && $bag->bagStatus->slug != 'expirado')
                        <a href="{{ route('admin::bags.show',[ $bag->key ]) }}" class="icon" target="_blank">
                            <i class="fa fa-eye" aria-hidden="true"></i>
                        </a>
                    @else
                        -
                    @endif
                </td>
                <td class="carts--cell carts--billing">
                    @if ($bag->bagStatus->paid)
                        <a href="{{ $bag->edit_bag_url }}" class="icon" target="_blank">
                            <i class="fa fa-pencil" aria-hidden="true"></i>
                        </a>
                    @else
                        -
                    @endif
                </td>
            </tr>
        @endforeach
    </tbody>

</table>
