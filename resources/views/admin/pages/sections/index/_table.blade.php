<table class="table">
	<thead class="text__p text__p-table-head">
		<tr>
			<th>Nombre</th>
			<th class="text-center">Tipo</th>
			<th class="text-center">Template</th>
			<th class="text-center">Páginas</th>
			<th class="text-center">Editar</th>
			<th class="text-center">Borrar</th>
		</tr>
	</thead>

	<tbody class="text__p">
		<tr v-for="section in list" >
			<td>
				@{{ section.index }}
				<small>
					<br>
					@{{{ section.description }}}
				</small>
			</td>
			<td class="text-center">
				@{{{ section.type_label }}}
			</td>
			<td class="text-center">
				@{{ section.template_path }}
				<br>
				<small>
					@{{{ section.implode_editable_contents }}}
				</small>
			</td>
			<td class="text-center">
				@{{{ section.implode_pages_index }}}
			</td>
			<td class="text-center">
				<a href="#" data-toggle="modal" data-target="#pagesections-modal-edit" data-index="@{{$index}}" class="icon">
                    <i class="fa fa-pencil" aria-hidden="true"></i>
                </a>
			</td>
			<td class="text-center">
				@include('admin.pages.sections._delete-form')
			</td>
		</tr>
	</tbody>
</table>
