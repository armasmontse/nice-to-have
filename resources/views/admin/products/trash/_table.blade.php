<table class="table dataTable_JS">
    <thead class="text__p text__p-table-head">
        <tr>
            <th>Código</th>
            <th>Nombre</th>
            <th>Proveedor</th>
            <th>Subcategorías</th>
            <th>Subtipos</th>
            <th>Borrado</th>
            <th class="text-center" >Reactivar</th>
        </tr>
    </thead>
    <tbody class="text__p">
        @foreach ($products_disabled as $product_disable)
            <tr class=" ">
                <td class="">
                    {{ $product_disable->code }}
                </td>
                <td class="">
                    {{ $product_disable->getImpldeValue("title") }}
                </td>
                <td class="">
                    {{ $product_disable->provider->label }}
                </td>

                <td class="">
                    @foreach ($product_disable->subcategories as $subcategory)
                        {{ $subcategory->getImpldeValue("label") }}<br>
                    @endforeach
                </td>

                <td class="">
                    @foreach ($product_disable->subtypes as $subtype)
                        {{ $subtype->getImpldeValue("label") }}<br>
                    @endforeach
                </td>
                <td class="">
                    {{ $product_disable->deleted_at }}
                </td>

                <td class="text-center">

                        <div class="">
                            {!! Form::open([
                                'method'             => 'patch',
                                'route'              => ['admin::products.recovery',$product_disable->id],
                                'role'               => 'form' ,
                                'id'                 => 'recovery_product-'.$product_disable->id.'_form',
                            ]) !!}

                                <button type="submit" class="btn-link " form ="recovery_product-{{$product_disable->id}}_form">
                                    <i class="fa fa-repeat" aria-hidden="true"></i>
                                </button>

                            {{ Form::close() }}
                        </div>

                </td>


            </tr>
        @endforeach
    </tbody>
</table>
