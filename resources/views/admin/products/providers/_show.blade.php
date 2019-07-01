@extends('layouts.admin')

@section('title')
    Proveedor |
@endsection

@section('h1')
    Proveedor {{ $provider->label }}
@endsection

@section('content')

<table class="table bordered highlight responsive-table dataTable_JS">
    <thead class="text__p text__p-table-head">
        <tr>
            <th class="text-center">Producto</th>
            <th class="text-center">Desglose</th>
            <th class="text-center">Total</th>
            <th class="text-center">Carrito</th>
            <th class="text-center">Fecha de compra</th>
            <th class="text-center">Estatus</th>
            <th class="text-center">Editar</th>
        </tr>
    </thead>
    <tbody class="text__p">
        @foreach ($products as $product)
            @foreach ($product->skus as $sku)
                @foreach ($sku->bags as $bag)

                    <tr>
                        <td>
                            <strong>Sku:</strong><span style="text-transform: uppercase;">{{ $sku->sku }}</span> <br>
                            <strong>Nombre:</strong> {{ $product->title }} <br>
                            <strong>Variación:</strong> {{ $sku->description }}
                        </td>

                        <td>
                            <strong>Precio:</strong> ${{ $bag->pivot->price }} <br>
                            <strong>Costo de Envío:</strong> ${{ $bag->pivot->shipping_rate }} <br>
                            <strong>Cantidad:</strong> {{ $bag->pivot->quantity }} <br>
                        </td>

                        <td>
                            ${{ ($bag->pivot->price + $bag->pivot->shipping_rate) * $bag->pivot->quantity }}
                        </td>

                        <td class="text-center">
                            @if (!$bag->bagStatus->active && $bag->bagStatus->slug != 'expirado')
                                <a href="{{ route('admin::bags.show',[ $bag->key ]) }}" target="_blank">
                                    #{{ $bag->key }}
                                </a>
                            @else
                                -
                            @endif
                        </td>

                        <td class="text-center">
                            {{ $bag->purshased_at->format('d/m/Y H:m') }}
                        </td>

                        <td class="text-center">
                            {{ $bag->bagStatus->label }} <br>
                        </td>

                        <td class="text-center">
                            <a href="{{ route('admin::bags.edit', $bag->key) }}" class="icon" target="_blank">
                                <i class="fa fa-pencil" aria-hidden="true"></i>
                            </a>
                        </td>
                    </tr>

                @endforeach
            @endforeach
        @endforeach
    </tbody>
</table>

@endsection
