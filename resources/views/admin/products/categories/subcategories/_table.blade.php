<table class="table">
    <thead class="text__p text__p-table-head">
        <tr>
            <th>categoría</th>
            <th class="text-center">orden</th>
            <th class="text-center">subcategoría</th>
            <th class="text-center">Editar</th>
            <th class="text-center">Borrar</th>
        </tr>
    </thead>

    <tbody class="text__p">
        <tr v-for="subcategory in list">

            <td>
                @{{ subcategory.category_label }}
            </td>

            <td class="text-center">
                @{{ subcategory.order }}
            </td>

            <td class="text-center">
                @{{ subcategory.label }}
            </td>

            <td class="text-center">
                <a href="#" data-toggle="modal" data-target="#subcategory-edit" data-index="@{{$index}}" class="icon" >
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
            </td>

            <td class="text-center">
                @include('admin.products.categories.subcategories._delete-form')
            </td>

        </tr>
    </tbody>
</table>
