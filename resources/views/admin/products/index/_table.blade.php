<table class="dataTable_JS table">
    <thead class="text__p text__p-table-head">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Proveedor</th>
            <th>Subcategorías</th> 
            <th>Subtipos</th>
            <th>Estatus</th>
            <th class="text-center" >Ver</th>
            <th class="text-center" >Editar</th>
            <th class="text-center" >Borrar</th>
        </tr>
    </thead>

    <tbody class="text__p">
        @foreach ($products as $product_edit)
            <tr class="">
                <td class="">
                    {{ $product_edit->code }}
                </td>
                <td class="">
                    {{ $product_edit->getImpldeValue("title") }}
                </td>
                <td class="">
                    {{ $product_edit->provider->label }}
                </td>

                <td class="">
                    @foreach ($product_edit->subcategories as $subcategory)
                        <strong>{{$subcategory->category_label}}: </strong>{{ $subcategory->getImpldeValue("label") }}<br>
                    @endforeach
                </td>

                <td class="">
                    @foreach ($product_edit->subtypes as $subtype)
                        <strong>{{$subtype->type_label}}: </strong>{{ $subtype->getImpldeValue("label") }}<br>
                    @endforeach
                </td>

                <td class="">
                    @if ( $product_edit->publish)
                        {{ $product_edit->publish->label }}<br>
                        {{ $product_edit->publish->date }}
                    @endif
                </td>
                <td class="text-center">
                    <a href="{{ $product_edit->client_url }}" class="icon">
                        <i class="fa fa-eye" aria-hidden="true"></i>
                    </a>
                </td>
                <td class="text-center">
                    <a href="{{ $product_edit->edit_url}}" class="icon">
                        <i class="fa fa-pencil" aria-hidden="true"></i>
                    </a>
                </td>
                <td class="text-center">
                    {!! Form::open([
                        'method'             => 'delete',
                        'route'              => ['admin::products.destroy',$product_edit->id],
                        'role'               => 'form' ,
                        'id'                 => 'delete_product-'.$product_edit->id.'_form',
                        'class'              => 'form-inline'
                    ]) !!}

                        <button type="submit" class="icon" form ="delete_product-{{$product_edit->id}}_form">
                            <i class="fa fa-trash" aria-hidden="true"></i>
                        </button>
                    {{ Form::close() }}
                </td>

            </tr>
        @endforeach
    </tbody>
</table>
