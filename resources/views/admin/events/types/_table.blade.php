<table class="table">
	<thead class="text__p text__p-table-head">
		<tr>
			<th>Orden</th>
			<th class="text-center">Tipo de evento</th>
			<th class="text-center">Título</th>
			<th>Descripción</th>
			<th class="text-center">Editar</th>
			<th class="text-center">Borrar</th>
		</tr>
	</thead>

	<tbody class="text__p">
		<tr is="single-event"
			v-for="type in list"
			:index="$index"
			:list.sync="list"
			v-ref:list
			:type="type"
			:ref-path="['$root', '$refs', 'types', '$refs', 'list', $index]"
			:current-image="type.thumbnail_image"
			:photoable-id="type.id"
			:photoable-type="'type'"
			:use="'thumbnail'"
			:class="''"
			:default-order="'null'"
		>
		</tr>
	</tbody>
</table>

<script type="x/templates" id="single-event-template">
	<tr>
		<td>
			@{{ type.order }}
		</td>

		<td class="text-center">
			@{{ type.label }}
			@include('admin.media_manager.vue.vue-image')
		</td>

		<td>
			@{{ type.title }}
		</td>

		<td>
			@{{ type.description }}
		</td>

		<td class="text-center">
			<a href="#" data-toggle="modal" data-target="#type-edit" data-index="@{{index}}" class="icon" >
				<i class="fa fa-pencil" aria-hidden="true"></i>
			</a>
		</td>

		<td class="text-center">
			@include('admin.events.types._delete-form')
		</td>
	</tr>
</script>
