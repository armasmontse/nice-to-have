 <table class="table bordered highlight responsive-table dataTable_JS">
    <thead class="text__p text__p-table-head">
        <tr>
            <th class="text-center">Tipo de código</th>
            <th class="text-center">Código</th>
            <th class="text-center">Descuento</th>
            <th class="text-center">Inicio</th>
            <th class="text-center">Caduca</th>
            <th class="text-center">Descripción</th>
            <th class="text-center">Editar</th>
            <th class="text-center">Eliminar</th>
        </tr>
    </thead>
    <tbody class="text__p">
        @foreach ($discount_codes as $discount_code)
            <tr>
                <td>
                    {{ $discount_code->discountCodeType->label }}
                    {{ $discount_code->unique ? '(Único)' : '' }}
                </td>

                <td>
                    {{ $discount_code->code }}
                </td>

                <td>
                    {{ $discount_code->value_label }}
                </td>

                <td class="text-center">
                    {{ $discount_code->initial_date->format('d/m/Y') }}
                </td>

                <td class="text-center">
                    {{ $discount_code->end_date->format('d/m/Y') }}
                </td>

                <td class="text-center">
                    {{ $discount_code->description }}
                </td>

                <td class="text-center">
                    <a href="{{ route('admin::discount_codes.edit', $discount_code->id) }}" class="icon" >
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </td>

                <td class="text-center">
                    @include('admin.discount_codes._delete')
                </td>
            </tr>
        @endforeach
    </tbody>
</table>