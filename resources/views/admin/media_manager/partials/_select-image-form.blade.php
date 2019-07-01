<div class="col-xs-12 media-manager__col-btn">
	{!! Form::open([
			'method' => 'POST',
			'class' => 'input__file',
			'route'                => ['admin::photos.ajax.associate', '&#123;&#123;chosen_img.id&#125;&#125;'],
			'role'                  => 'form',
			'id'                    => 'associate_photo_form',
			'v-on:submit.prevent'   => 'makePost'
			]) !!}
	{{-- inputs hidden para pasar data de la imagen id, photoable_type, photoable_id, use, class (default=null), order (default null) --}}
			{{-- {!! Form::hidden("photo_id", null, [
				 'required' => 'required',
				 'form'     => 'associate_photo_form',
				 'v-model' => 'chosen_img.id'
			]) !!} --}}
			{!! Form::hidden("photoable_id", null, [
				 'required' => 'required',
				 'form'     => 'associate_photo_form',
				 'v-model' => 'active_calling_component.photoable_id'
			]) !!}
			{!! Form::hidden("photoable_type", null, [
				 'required' => 'required',
				 'form'     => 'associate_photo_form',
				 'v-model' => 'active_calling_component.photoable_type'
			]) !!}
			{!! Form::hidden("use", null, [
				 'required' => 'required',
				 'form'     => 'associate_photo_form',
				 'v-model' => 'active_calling_component.use'
			]) !!}
			{!! Form::hidden("class", null, [
				 'required' => 'required',
				 'form'     => 'associate_photo_form',
				 'v-model' => 'active_calling_component.class'
			]) !!}
			{!! Form::hidden("order", null, [
				 'required' => 'required',
				 'form'     => 'associate_photo_form',
				 'v-model' => 'active_calling_component.order'
			]) !!}

			{!! Form::submit('Seleccionar', ['class' => 'btn btn-primary input-sm input input__submit input__submit--wider']) !!}
	{!! Form::close() !!}
	</div>
