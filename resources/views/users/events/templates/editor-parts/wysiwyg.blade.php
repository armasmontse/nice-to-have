<p class="userEvent__title mb3m">{{$title}}</p>
<div class="userEvent__box">
	<p class="userEvent__paragraph">{{$description ?? ''}}</p>
	<div class="userEvent__template-edit-editor mb3m">
		<cltvo-editor 
			form="{{$form}}"
			name="html"
			:value.sync="selected_section.html"
			>	
		</cltvo-editor>
	</div>
</div>
