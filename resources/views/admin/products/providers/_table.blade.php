<table class="table">
    <thead class="text__p text__p-table-head">
        <tr>
            <th>Proveedor</th>
            <th class="text-center">Ver</th>
            <th class="text-center">Editar</th>
            <th class="text-center">Borrar</th>
        </tr>
    </thead>

    <tbody class="text__p">
        <tr v-for="provider in list">
            <td>
                @{{provider.label}}
            </td>

            <td class="text-center">
                <a href="@{{ provider.admin_url }}" class="btn-floating waves-effect waves-light" target="_blank">
                    <i class="fa fa-eye fa-lg" aria-hidden="true"></i>
                </a>
            </td>

            <td class="text-center">
                <a href="#" data-toggle="modal" data-target="#provider-edit" data-index="@{{$index}}" class="icon" >
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
            </td>

            <td class="text-center">
                @include('admin.products.providers._delete-form')
            </td>
        </tr>
    </tbody>
</table>
