<p class="userEvent__title mb3m">{{$title ?? ''}}</p>
<div class="userEvent__box">
	<p class="userEvent__paragraph">{{$description  ?? ''}}</p>
	<div class="userEvent__template-edit-editor mb3m">
		<input 
			type="text" 
			class="input" 
			form="{{$form}}"
			name="title"
			placeholder="{{$placeholder ?? ''}}" 
			v-model="selected_section.title">
	</div>
</div>
