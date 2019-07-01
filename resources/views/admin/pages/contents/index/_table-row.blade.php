<script type="x/templates" id="pages-group-template">
    <div :id="label" class="collection" >
        <table class="table">
            <thead class="text__p text__p-table-head">
                <tr>
                    <th></th>
                    <th>Nombre</th>
                    <th>Estado</th>
                    <th class="text-center">Ver</th>
                    <th class="text-center">Editar</th>
                </tr>
            </thead>

            <tbody class="text__p">
                <tr :class="index" v-for="page in sortable_list">
                    <td class="cursor-sortable text-center">

                        <span class="btn-floating waves-effect waves-light"
                            @click="move(-1, $index, sortable_list)"
                            >
                            <i class="fa fa-arrow-circle-up fa-2x" aria-hidden="true"
                                v-if = 'list.length > 1'
                            ></i>
                        </span>
                        <span class="btn-floating waves-effect waves-light"
                            @click="move(1, $index, sortable_list)"
                            >
                            <i class="fa fa-arrow-circle-down fa-2x" aria-hidden="true" v-if = 'list.length > 1'></i>
                        </span>
                    </td>
                    <td>
                        @{{{ page.complete_label }}}
                        <small v-if='page.main' >
                            <br>
                            Página principal del sitio
                        </small>

                    </td>
                    <td>
                        @{{{ page.publish.label }}}
                    </td>
                    <td  class="text-center" >
                        <a href="@{{ page.public_url }}" class="btn-floating waves-effect waves-light" target="_blank">
                            <i class="fa fa-eye fa-lg" aria-hidden="true"></i>
                        </a>
                    </td>
                    <td class="text-center" >
                        <a href="@{{ page.edit_content_url }}" class="btn-floating waves-effect waves-light">
                            <i class="fa fa-pencil fa-lg" aria-hidden="true"></i>
                        </a>
                    </td>
                </tr>
            </tbody>
        </table>
        @include('admin.pages.contents.index._sort-form')
    </div>
</script>
