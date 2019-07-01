<table class="table">
    <thead class="text__p text__p-table-head">
        <th>orden</th>
        <th>categoría</th>
        <th class="text-center">Editar</th>
        <th class="text-center">Borrar</th>
    </thead>

    <tbody class="text__p">
        <tr v-for="category in list">
            <td>
                @{{ category.order }}
            </td>

            <td>
                @{{ category.label  }}
            </td>

            <td class="text-center">
                <a href="#" data-toggle="modal" data-target="#category-edit" data-index="@{{$index}}" class="icon" >
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
            </td>

            <td class="text-center">
                @include('admin.products.categories._delete-form')
            </td>
        </tr>
    </tbody>
</table>
