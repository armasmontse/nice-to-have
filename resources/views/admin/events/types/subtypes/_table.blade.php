<table class="table">
    <thead class="text__p text__p-table-head">
        <tr>
            <th>Tipo de evento</th>
            <th class="text-center">Orden</th>
            <th class="text-center">Subtipo de evento</th>
            <th class="text-center">Editar</th>
            <th class="text-center">Borrar</th>
        </tr>
    </thead>

    <tbody class="text__p">
        <tr v-for="subtype in list">
            <td>
                @{{ subtype.type_label }}
            </td>

            <td class="text-center">
                @{{ subtype.order }}
            </td>

            <td class="text-center">
                @{{ subtype.label }}
            </td>

            <td class="text-center">
                <a href="#" data-toggle="modal" data-target="#subtype-edit" data-index="@{{$index}}" class="icon">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
            </td>

            <td class="text-center">
                @include('admin.events.types.subtypes._delete-form')
            </td>
        </tr>
    </tbody>
</table>
