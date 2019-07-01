 <table class="table bordered highlight responsive-table dataTable_JS">
    <thead class="text__p text__p-table-head">
        <tr>
            <th class="text-center">Tipo de código</th>
            <th class="text-center">Código</th>
            <th class="text-center">Descuento</th>
            <th class="text-center">Inicio</th>
            <th class="text-center">Caduca</th>
            <th class="text-center">Descripción</th>
            <th class="text-center">Activar</th>
        </tr>
    </thead>
    <tbody class="text__p">
        @foreach ($discount_codes_disabled as $discount_code_disabled)
            <tr>
                <td>
                    <strong>Tipo:</strong> <span>{{ $discount_code_disabled->unique_label }}</span> <br>
                    <strong>Variación:</strong> <span>{{ $discount_code_disabled->discountCodeType->label }}</span>
                </td>

                <td>
                    {{ $discount_code_disabled->code }}
                </td>

                <td>
                    {{ $discount_code_disabled->discount }}
                </td>

                <td class="text-center">
                    {{ $discount_code_disabled->initial_date->format('d/m/Y') }}
                </td>

                <td class="text-center">
                    {{ $discount_code_disabled->end_date->format('d/m/Y') }}
                </td>

                <td class="text-center">
                    {{ $discount_code_disabled->description }}
                </td>

                <td class="text-center">
                    {!! Form::open([
                        'method'    => 'PATCH',
                        'route'     => ['admin::discount_codes.recovery', $discount_code_disabled->id],
                        'role'      => 'form'
                    ]) !!}

                        <button type="submit" class="btn-link">
                            <i class="fa fa-repeat" aria-hidden="true"></i>
                        </button>

                    {{ Form::close() }}
                </td>
            </tr>
        @endforeach
    </tbody>
</table>