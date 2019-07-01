<div class="userEvent__template-edit">
	<div class="checkout__box-left">

		<div v-if="selected_section.event_template_header_id">

			{!! Form::open([
				'method'		=> 'PATCH',
				'route'			=> ['user::events.template.ajax.header',$user->name,$personal_event->slug],
				'role'			=> 'form' ,
				'id'			=> 'updatetemplate_form',
				'v-on:submit.prevent'	=> 	'post'
			]) !!}

			@include('users.events.templates.editor-parts.color-selector', [
				'title' 		=> '3.1 Selecciona el color de fondo:',
				'form'			=> 	'updatetemplate_form'
			])

			@include('users.events.templates.editor-parts.header-image-color-selector', ['title' => '3.2 Selecciona una imagen o color de portada:', 'form'	=> 	'updatetemplate_form'])

			@include('users.events.templates.editor-parts.countdown', [
				'title' 		=> '3.3 cuenta regresiva al día DE EVENTO:',
				'form'			=> 'updatetemplate_form'
			])

			@include('users.events.templates.editor-parts.wysiwyg', [
				'title' 		=> '3.4 Texto de portada:',
				'description'	=> 'Esta información aparecerá en la portada de la web de evento. En este texto puedes informar sobre el tipo de evento, donde se realizará o dar un pequeño mensaje. En caso de no desear texto, este espacio no se mostrará.',
				'form' 			=> 'updatetemplate_form'
			])

			@include('users.events.templates.editor-parts.header-status', [
				'form'			=> 	'updatetemplate_form'
			])

			{!! Form::close() !!}

		</div>

		<div>

			{!! Form::open([
				'method'		=> 'PATCH',
				'route'			=> ['user::events.template.sections.ajax.update',$user->name,$personal_event->slug, '&#123;&#123;selected_section.id&#125;&#125;' ],
				'role'			=> 'form' ,
				'id'			=> 'updatesection_form',
				'v-on:submit.prevent'	=> 	'post'
			]) !!}

			{{-- Se muestran inputs de acuerdo al tipo de sección --}}
			<div v-if="selected_section.publish !== undefined && selected_section.event_template_section_type.rules.title">
				@include('users.events.templates.editor-parts.title', ['title' => 'Titulo:', 'placeholder' => 'Titulo de la Sección', 'form'	=> 	'updatesection_form'])
			</div>

			<div v-if="selected_section.publish !== undefined && selected_section.event_template_section_type.rules.html">
				@include('users.events.templates.editor-parts.wysiwyg', ['title' => 'Contenido:', 'form' => 'updatesection_form'])
			</div>

			<div v-if="selected_section.publish !== undefined">
				@include('users.events.templates.editor-parts.color-selector', ['title' => 'Selecciona el color de fondo:', 'form'	=> 	'updatesection_form'])
			</div>

			<div v-if="selected_section.publish !== undefined && selected_section.event_template_section_type.rules.link">
				@include('users.events.templates.editor-parts.url', ['title' => 'URL', 'placeholder' => 'http://url.com/...', 'form'	=> 	'updatesection_form'])
			</div>

			<div v-if="selected_section.publish !== undefined && selected_section.event_template_section_type.rules.iframe">
				@include('users.events.templates.editor-parts.iframe', ['title' => 'iframe', 'placeholder' => 'iframe', 'form'	=> 	'updatesection_form'])
			</div>

			<div v-if="selected_section.publish !== undefined && selected_section.event_template_section_type.rules.photo">
				@include('users.events.templates.editor-parts.image', ['title' => 'Selecciona una imagen:', 'form'	=> 	'updatesection_form'])
			</div>
			{{--  /Se muestran inputs de acuerdo al tipo de sección --}}

			<div v-if=" selected_section.publish !== undefined ">
				@include('users.events.templates.editor-parts.status', ['form'	=> 	'updatesection_form'])
			</div>

			{!! Form::close() !!}

			{!! Form::open([
				'method'		=> 'POST',
				'route'			=> ['user::events.template.ajax.photos',$user->name, $personal_event->slug ],
				'role'			=> 'form' ,
				'class'			=> 'userEvent__template-edit-img-file--hidden-form',
				'id'			=> 'addimage_form',
				'v-on:submit.prevent'	=> 	'post'
			]) !!}

				<input type="hidden" name="photoable_id" :value="selected_section.id ? selected_section.id : store.personal_event.event_template.id" form="addimage_form">
				<input type="hidden" name="photoable_type" :value="selected_section.event_template_header_id ? 'template' : 'section'" form="addimage_form">
				<div id="addimage_form-main-input">
				{{-- IMPORTANTE: dejar div aunque esté vacio, es necesaria para hacer el post de las imagenes, sacándolas de la otra forma y poniéndolas acá --}}

				</div>
			{!! Form::close() !!}

		</div>

	</div>
</div>

{{-- 'texto' --}}
{{-- <div v-if=" selected_section.event_template_section_type_id === 1 ">
	@include('users.events.templates.editor-parts.title', ['title' => '3.1 Titulo texto', 'placeholder' => 'Titulo de la Sección', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.wysiwyg', ['title' => '3.2 Contenido:', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.color-selector', ['title' => '3.3 Selecciona el color de fondo:', 'form'	=> 	'updatesection_form'])
</div> --}}

{{-- 'imagen' --}}
{{-- <div v-if=" selected_section.event_template_section_type_id === 2 ">
	@include('users.events.templates.editor-parts.title', ['title' => '3.1 Titulo de imagen', 'placeholder' => 'Titulo de la Sección', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.image', ['title' => '3.2 Selecciona una imagen:', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.color-selector', ['title' => '3.3 Selecciona el color de fondo:', 'form'	=> 	'updatesection_form'])
</div> --}}

{{-- 'video' --}}
{{-- <div v-if=" selected_section.event_template_section_type_id === 3 ">
	@include('users.events.templates.editor-parts.title', ['title' => '3.1 Titulo de video', 'placeholder' => 'Titulo de la Sección', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.url', ['title' => '3.2 URL', 'placeholder' => 'http://url.com/...', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.iframe', ['title' => '3.3 iframe', 'placeholder' => 'iframe', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.color-selector', ['title' => '3.4 Selecciona el color de fondo:', 'form'	=> 	'updatesection_form'])
</div> --}}

{{-- 'mapa' --}}
{{-- <div v-if=" selected_section.event_template_section_type_id === 4 ">
	@include('users.events.templates.editor-parts.title', ['title' => '3.1 Titulo', 'placeholder' => 'Titulo de la Sección de Mapa', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.url', ['title' => '3.2 URL', 'placeholder' => 'http://url.com/...', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.iframe', ['title' => '3.3 iframe', 'placeholder' => 'Titulo de la Sección', 'form'	=> 	'updatesection_form'])

	@include('users.events.templates.editor-parts.color-selector', ['title' => '3.4 Selecciona el color de fondo:', 'form'	=> 	'updatesection_form'])
</div> --}}

{{--
	//Ejemplos de inputs

	@include('users.events.templates.editor-parts.color-selector', ['title' => '3.1 Selecciona el color de fondo:'])

		@include('users.events.templates.editor-parts.header-image-color-selector', ['title' => '3.2 Selecciona una imagen o color de portada:'])


	@include('users.events.templates.editor-parts.wysiwyg', ['title' => '3.4 Texto de portada:', 'description'	=> 	'Esta información aparecerá en la portada de la web de evento. En este texto puedes informar sobre el tipo de evento, donde se realizará o dar un pequeño mensaje. En caso de no desear texto, este espacio no se mostrará.'])

	@include('users.events.templates.editor-parts.title', ['title' => '3.4 Titulo', 'placeholder' => 'Titulo de la Sección'])
	@include('users.events.templates.editor-parts.url', ['title' => '3.4 URL', 'placeholder' => 'http://url.com/...'])

	@include('users.events.templates.editor-parts.iframe', ['title' => '3.4 iframe', 'placeholder' => 'Titulo de la Sección'])
 --}}
