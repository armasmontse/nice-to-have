<p class="userEvent__title mb2m">{{$title ?? ''}}</p>
<div class="userEvent__template-edit-color-container userEvent__template-edit-color-container--compensate-top">
	<div v-for="color in selected_palette.colors" 
		v-on:click="setBackgroundColor(selected_section, color.backgroundColor)"
		class="userEvent__template-edit-color-box"
		:class="{'selected' : color.backgroundColor.replace('#', '') === selected_section.background_color.replace('#', '')}">{{-- nos aseguramos de que hagamos el test sin '#' --}}
		<div class="userEvent__template-edit-color" :style="color"></div>
	</div>
</div>
<input type="hidden" form="{{$form}}" name="background_color" v-model="selected_section.background_color">