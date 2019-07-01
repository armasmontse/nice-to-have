@extends('layouts.client', ['body_id'	=> 	'web-template-vue'])

@section('title')
		| Web de evento
@endsection

@section('content')

<div class="grid__row userEvent">
	@include('users.events.general.head')
</div>

@if ($personal_event->isFinish)
	@if ($personal_event->eventTemplate->publish)
		<div class="grid__container">
			@include('client.events.web', [
				"event"             => $personal_event,
	            "template_name"     => $personal_event->template_view,
	            "template"          => $personal_event->eventTemplate,
	            'sections'          => $personal_event->eventTemplate->eventTemplateSections()->where('publish', true)->orderBy('order')->get()
			])
		</div>
	@else
		@if (!is_page('user::events.account'))
		<div class="grid__container userEvent__intro">
			<div class="userEvent__paragraph">
				No publicaste ninguna web para tu evento.
			</div>
		</div>
		@endif
	@endif
@else
	{{-- Template Header --}}
	<div>
		{!! Form::open([
				'method' 	=> 'PATCH',
				'route'		=> ['user::events.template.update', $user->name, $personal_event->slug],
				'role'		=> 'form',
				'id'		=> 'updatedesign_template',
				'v-on:submit.prevent'	=> 	'post'
			])
		!!}
			{{-- Slider--}}
			<div class="grid__container">
				<p class="userEvent__title">1. Selecciona el diseño que más te guste:</p>
				<div class="userEvent__template-selector w100" id="userEvent__template-selector">
					<div class="swiper-container userEvent__slider mb4m">
						<div class="swiper-wrapper">
							<div class="swiper-slide userEvent__slider-slide" v-for="template in store.template_headers" v-on:click="selectTemplate(template)">
								<img class="userEvent__slider-img"
									:class="{'selected': template.id === selected_template.event_template_header_id}"
									:src="store.template_headers_thumbnails[template.id]"
									alt="">
							</div>
						</div>
					</div>
					<div class="grid__container mb4m">
						<div class="userEvent__slider-nav-container">
							<div class="swiper-button-prev userEvent__slider-nav--prev userEvent__slider-nav--size-arrow"></div>
							<div class="swiper-button-next userEvent__slider-nav--next userEvent__slider-nav--size-arrow"></div>
						</div>
					</div>
				</div>
			</div>

			{{-- Paleta --}}
			<div class="grid__container">
				<div class="userEvent__palette-container w100">
					<p class="userEvent__title">2. Selecciona la paleta de color:</p>
					<div class="userEvent__box userEvent__box--sm">
						<p class="userEvent__paragraph">
							{!! $web_event_change_color_copy !!}
							{{-- Si decides cambiar de paleta de color, no olvides sustituir el color de cada sección para que no mezcles combinaciones. --}}
						</p>
					</div>
					<div class="flex-cont--sb flex-wrap mb3m">
						<div v-for="palette in palettes" v-on:click="onPaletteChange('updatedesign_template', palette.id)"
							class="userEvent__palette-color-container"
							:class="{'selected' : palette.id === selected_palette_id}"
						>
							<span class="userEvent__palette-color" :style="color" v-for="color in palette.colors"></span>
						</div>
					</div>

					<div class="userEvent__box userEvent__box--sm flex-cont--center mb4m">
						<input type="hidden" v-model="selected_template.event_template_header_id" name="template">
						<input type="hidden" v-model="selected_palette.id" name="palette">
						<input type="submit" class="input__submit black" value="Guardar diseño y paleta de color">
					</div>
					<div class="divisor mb3m"></div>
				</div>
			</div>
		{!! Form::close() !!}
	</div>

	{{-- Publication --}}
	<div class="grid__container">
		<div class="userEvent__template-sections-container w100">
			<div class="grid__container">
				<div class="grid__col-1-2 checkout__col-1-2">
					<p class="userEvent__title mb3m">3. Edita y/o agrega nuevas secciones a tu WEB:</p>
					<div class="userEvent__box userEvent__box--sm flex-cont--sb flex-col mb3m">
						<div class="tac">
							<span class="input__submit mb2-3m" @click="openModal('create_section_modal')">Agregar nueva sección</span>
						</div>
						<div class="tac">
							<a class="input__submit" href="{{ $personal_event->public_url }}" target="_blank">Previsualizar web de evento</a>
						</div>
					</div>

					<div class="userEvent__box userEvent__box--sm mb2m">
						<p class="userEvent__paragraph">
							{!! $web_event_new_section_instructions_copy !!}
							{{-- Selecciona una sección para poder editar su contenido. Puedes acomodar el orden de las secciones haciendo click con tu mouse. --}}
						</p>
					</div>
					<div class="checkout__box checkout__box-right mb3m">
						{{-- Portada --}}
						<templates-sortable-list
							:list="store.personal_event.event_template.event_template_sections"
							:section-names="store.section_type_names"
							>
						</templates-sortable-list>
					</div>
				</div>
				<div class="grid__col-1-2 checkout__col-1-2 mb3m">
					@include('users.events.templates.template-section-editors')
				</div>
			</div>
			<div class="divisor mb3m"></div>
		</div>
	</div>

	{{-- Publication --}}
	<div id="publish_template" class="grid__container">
		<div class="userEvent__publish-container w100">
			<p class="userEvent__title">4. Publica tu Web de Evento:</p>
			<div class="userEvent__box userEvent__box--sm">
				@if (!$personal_event->eventStatus->publish && !$personal_event->eventTemplate->publish)
					<p class="userEvent__paragraph mb3m">
						{!! $web_event_publish_web_event_copy !!}
						{{-- Para que tu web de evento esté online es necesario --}}
						<a href="{{ route('user::events.profile',[$user->name,$personal_event->slug]) }}#activate_event">
							<span class="userEvent__publish-link--activate">activar el evento.</span>
						</a>
					</p>
				@elseif ($personal_event->eventStatus->publish && !$personal_event->eventTemplate->publish)
					<div class="userEvent__box userEvent__box--sm flex-cont--center mb4m">
						{!! Form::open([
								'method' 	=> 'PATCH',
								'route'		=> ['user::events.template.publish', $user->name, $personal_event->slug],
								'role'		=> 'form',
								'id'		=> 'publish_template_form'
							])
						!!}
						<input type="submit" class="input__submit black" value="Publicar web del evento">
						{!! Form::close() !!}
					</div>
				@endif
				<p class="userEvent__publish-status">Estatus de la Web de Evento: {{ !$personal_event->eventTemplate->publish ? 'NO PUBLICADA' : 'PUBLICADA' }}</p>
				<div class="flex-cont--center">
					<a href="{{ $personal_event->public_url }}" class="userEvent__publish-link" target="_blank">{{ $personal_event->public_url }}</a>
				</div>
			</div>
		</div>
	</div>

@endif

@endsection

@section('modals')
	@include('users.events.templates.modals')
@endsection


@section('vue_templates')

{{-- cltvoEditor --}}
@include('general.cltvo-editor')

{{-- templatesSortableList --}}
<script type="x/templates" id="templates-sortable-list-template">
	<div>
		<div class="mb2m">
			<div class="userEvent__template-section" v-on:click.stop="selectSection(-1, true)">
				<div class="userEvent__template-section-type-container">
					<img src="{{asset('images/flechas-template-section.svg')}}" alt="" class="userEvent__template-section-type-arrows">
					<p class="userEvent__template-section-type userEvent__title">
						Portada
					</p>
				</div>
				<div class="flex-cont--sb">
					<span class="userEvent__template-section-delete"></span>{{-- no borrar --}}
					<span class="userEvent__template-section-status">Permanente</span>
				</div>
			</div>

			<div v-sortable="{ onUpdate: onUpdate,  handle: '.handle' }">
				<div class="userEvent__template-section" v-for="section in list" v-on:click="selectSection(section.id)">
					<div class='handle' >
						<div class="userEvent__template-section-type-container">
							<img src="{{asset('images/flechas-template-section.svg')}}" alt="" class="userEvent__template-section-type-arrows">
							<p class="userEvent__template-section-type userEvent__title">
								@{{section.title || sectionNames[section.event_template_section_type_id]}}
							</p>
						</div>
						<div class="flex-cont--sb">
							{!! Form::open([
								'method'		=> 'DELETE',
								'route'			=> ['user::events.template.sections.ajax.destroy',$user->name,$personal_event->slug, '&#123;&#123;section.id&#125;&#125;'],
								'role'			=> 'form' ,
								':id'			=> '"deletesections_"+$index+"form"',
								':data-id' => 'section.id',
								'v-on:submit.prevent'	=> 	'post'
							]) !!}
								<input type="submit" :form='"deletesections_"+$index+"form"' class="userEvent__template-section-delete" value="Eliminar">
							{!! Form::close() !!}

							<span class="userEvent__template-section-status" v-text="section.publish ? 'Visible' : 'Invisible'"></span>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="flex-cont--center">
			{!! Form::open([
				'method'		=> 'PATCH',
				'route'			=> ['user::events.template.sections.ajax.sort',$user->name,$personal_event->slug],
				'role'			=> 'form' ,
				'id'			=> 'updatesortedids_form',
				'v-on:submit.prevent'	=> 	'post'
			]) !!}
				<input type="hidden" form="updatesortedids_form" name="section_id[]" :value="id" v-for="id in sorted_ids">
				<input type="submit" form="updatesortedids_form" class="input__submit black" value="Guardar Orden">
			{!! Form::close() !!}
		</div>
	</div>
</script>
@endsection


@section('vue_store')
	 <script>
		 mainVueStore.palette_id = {{ $personal_event->eventTemplate->color_palette_id }}
		 mainVueStore.palettes = {!! json_encode($color_palettes) !!}
		 mainVueStore.template_headers = {!! json_encode($template_headers) !!}
		 mainVueStore.section_types = {!! json_encode($section_types) !!}
		 mainVueStore.sections = {!! json_encode($personal_event->eventTemplate->eventTemplateSections->sortBy('order')) !!}
		 mainVueStore.personal_event = {!! json_encode($personal_event) !!}

		 mainVueStore.template_headers_thumbnails = {//el numero de la propiedad corresponde al id del template
			[1]: "{{asset('images/img-plantillas-03.png')}}",
			[2]: "{{asset('images/img-plantillas-01.png')}}",
			[3]: "{{asset('images/img-plantillas-02.png')}}",
		}
		mainVueStore.event_date = {
            year: {{ $personal_event->utc_date->year }},
            month: {{ $personal_event->utc_date->month - 1  }}, //es 0 Index
            day:{{ $personal_event->utc_date->day }},
            hour:{{ $personal_event->utc_date->hour }},
            minutes: {{ $personal_event->utc_date->minute }},
            gmt: undefined // fecha en utc
        }
	 </script>
@endsection
