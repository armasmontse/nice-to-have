<p class="userEvent__title mb3m">{{$title ?? ''}}</p>
<div class="userEvent__box">
	<p class="userEvent__paragraph">{{$description  ?? ''}}</p>
	<div class="userEvent__template-edit-editor mb3m">
		<input type="url" class="input" placeholder="{{$placeholder ?? ''}}" name="link" v-model="selected_section.link">
	</div>
</div>
