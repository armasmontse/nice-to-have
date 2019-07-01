<p class="userEvent__title mb2m">{{$title ?? ''}}</p>
<div class="flex-cont mb3m">
	<div class="userEvent__template-edit-img-container">
		{{-- imagen --}}
		<div :style="{backgroundImage: 'url('+selected_section.thumbnail_image.url+')' }" class="userEvent__template-edit-img userEvent__template-edit-img--empty"  v-on:change="onAddedFile('addimage_form', $event)">
			<div v-if="!selected_section.thumbnail_image.url" 
				class="userEvent__template-edit-img-text-container"
				>
				<span class="userEvent__template-edit-img-text">+</span>
				<span class="userEvent__template-edit-img-text">Cargar imagen</span>
			</div>
			<input type="file" name="image" class="userEvent__template-edit-img-file">
		</div>
	</div>
</div>
