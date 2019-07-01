<p class="userEvent__title mb2m">{{$title ?? ''}}</p>
<div class="flex-cont mb3m">
	<div class="userEvent__template-edit-img-container">
		<div :style="{backgroundImage: 'url('+selected_section.thumbnail_image.url+')' }" class="userEvent__template-edit-img userEvent__template-edit-img--empty" v-on:change="onAddedFile('addimage_form', $event)">
			<div v-if="!selected_section.thumbnail_image.url" 
				class="userEvent__template-edit-img-text-container">
				<span class="userEvent__template-edit-img-text">+</span>
				<span class="userEvent__template-edit-img-text">Cargar imagen</span>
			</div>
			<input type="file" name="image" class="userEvent__template-edit-img-file">
		</div>
	</div>
	<div class="relative">{{-- previene crecimiento automático de los contenedores de abajo debido a flex --}}
		<div class="userEvent__template-edit-color-container center-y">
			<div v-for="color in selected_palette.colors"
				v-on:click="setImageBackgroundColor(selected_section, color.backgroundColor)"
				class="userEvent__template-edit-color-box"
				:class="{'selected' : color.backgroundColor.replace('#', '') === selected_section.image_background_color.replace('#', '')}">
				<div class="userEvent__template-edit-color" :style="color"></div>
			</div>
		</div>
	</div>
</div>
<input type="hidden" form="{{$form}}" name="image_background_color" v-model="selected_section.image_background_color">
