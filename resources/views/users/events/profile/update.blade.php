
	<div class="userEvent__columns--block">

		{!! Form::open([
			'method'             => "patch",
			'route'              => ["user::events.update",$user->name, $personal_event->slug],
			'role'               => 'form' ,
			'id'                 => "update_event_form"
			]) !!}

			<div class="userEvent__select--container">
				<p class="userEvent__title">Tipo de Evento</p>
				@if($personal_event->is_draft)
					<select class="form-control input__select userEvent__select userEvent__input" name="type_id" id="type_id" v-model="event_type" form='update_event_form'>
						<option value="" v-if="!store.types.data">Cargando tipos de evento...</option>
						<option value="" v-if="store.types.data">Selecciona un tipo de evento</option>
						<option :value="option.id" v-for="option in store.types.data" v-text="option.es_label"></option>
					</select>
				@else
					<div class="userEvent__input--container">
						<p class="userEvent__title ttn" v-text="typeLabel"></p>
					</div>
				@endif

			</div>

			<div class="userEvent__select--container">
				<p class="userEvent__title">Variación de Evento</p>
				@if($personal_event->is_draft)
					<select class="form-control input__select userEvent__select userEvent__input" name="subtype_id" id="subtype_id" v-model="type_variation" form='update_event_form'>
						@if ($personal_event->typeable->type_id)
							<option value="" v-if="!store.subtypes.data" selected="selected">Cargando variaciones...</option>
							<option value="" v-if="availableSubtypes.length === 0">Selecciona un tipo de evento</option>
							<option value="" v-else>Selecciona una variación</option>
							<option :value="option.id" v-for="option in availableSubtypes" v-text="option.es_label"></option>
						@else
							<option value="" selected="selected">Selecciona una Variación</option>
							<option :value="option.id" v-for="option in availableSubtypes" v-text="option.es_label"></option>
						@endif
					</select>
				@else
					<div class="userEvent__input--container">
						<p class="userEvent__title ttn" v-text="subtypeLabel"></p>
					</div>
				@endif
			</div>

			@if($personal_event->is_draft)
				{!! Form::submit("Guardar", [
					'class' => 'input__submit userEvent__btn userEvent__columns--btn',
					'form'  => "update_event_form"
				]) !!}
			@endif

		</div>

		<div class="userEvent__columns--block">
			<p class="userEvent__title">Exclusividad</p>
			<div class="userEvent__paragraph userEvent__columns--paragraph">
				{{-- {!! $create_event_phase_4_exclusiveness_copy !!} --}}
				@if ($personal_event->exclusive)
					Mesa de regalos única
				@else
					Tengo más mesas de regalos
				@endif
			</div>
		</div>

		<div class="userEvent__columns--block">

			{{-- @if($personal_event->is_draft) --}}
				<p class="userEvent__title mb3m">Información del Evento</p>
			{{-- @endif --}}

			@if($personal_event->is_draft)
				<input class="input form-control userEvent__input"
					type="text"
					placeholder="Nombre del Evento"
					name="name"
					id="name"
					form='update_event_form'
					value="{{ $personal_event->name }}">
				<p class="userEvent__help">Esta información aparecerá como título en la página web de evento</p>
			@else
				<div class="userEvent__input--container">
					<p class="userEvent__title">Nombre:</p>
					<div class="mb2m">
						<p class="userEvent__title ttn">{{ $personal_event->name }}</p>
					</div>
				</div>
			@endif

			@if($personal_event->is_draft)
				<div class="userEvent__input--container">
					<span class="userEvent__input--span">http://</span>
					<input class="input form-control userEvent__input userEvent__input--slug"
						type="text"
						placeholder="URL del Evento"
						name="slug"
						id="event_url"
						v-model="event_url"
						form='update_event_form'
						value="{{ $personal_event->slug }}">
					<span class="userEvent__input--span">.nicetohave.com.mx</span>
				</div>
				<p class="userEvent__help">Así se verá la URL: http://@{{event_url}}.nicetohave.com.mx</p>
			@else
				<div class="userEvent__input--container">
					<p class="userEvent__title">URL:</p>
					<div class="mb2m">
						<a href="http://{{ $personal_event->slug }}.nicetohave.com.mx" class="userEvent__title userEvent__link--basic ttn tdu ">http://{{ $personal_event->slug }}.nicetohave.com.mx</a>
					</div>
				</div>
			@endif

			@if($personal_event->is_draft)
				<input class="input form-control userEvent__input"
					type="text"
					placeholder="Nombre de los festejados"
					name="feted_names"
					id="feted_names"
					form='update_event_form',
					value="{{ $personal_event->feted_names }}">
				<p class="userEvent__help">Ej: Festejada Apellido y Festejado Apellido</p>
			@else
				<div class="userEvent__input--container">
					<p class="userEvent__title">Festejados:</p>
					<div class="mb2m">
						<p class="userEvent__title ttn">{{ $personal_event->feted_names }}</p>
					</div>
				</div>
			@endif
			
			<div class="relative create-event__input-container create-event__input-container--no-padding-left">
				<div class="relative z-0">{{-- zindex para la flecha --}}
					<input class="input create-event__input--transparent jq-datepicker_JS userEvent__input"
						type="text"
						name="date"
						id="event_date"
						placeholder="Fecha del evento (aaaa-mm-dd)" 
						value="{{ $personal_event->date->format('Y-m-d') }}"
						@click="datePickerOnFocus"
						@focusin="datePickerOnFocus"
						@change="unFlip" {{-- del arrow del input --}}
						@focusout="unFlip">
					<span :class="{'create-event__flippable-svg' : arrow_is_flipped}">
						{!! file_get_contents('images/flecha-select.svg') !!}
					</span>
				</div>
			</div>

			<select  class="form-control input__select userEvent__select userEvent__input mb2m"  
				id="hour" 
				name="hour"
				form='update_event_form'
				v-model="selected_hour">
				<option value="hour[0]">Hora del evento</option>
				<option v-for="hour in hours_array" :value="hour[0]" v-text="hour[1]"></option>
			</select>

			{!! Form::select("timezone",$time_zones_list, $personal_event->timezone, [
				'class'			=> 'form-control input__select userEvent__select userEvent__input',
				//'required'		=> 'required',
				'form'			=> 'update_event_form',
				'placeholder'	=>  'Zona Horaria'
			]) !!}

			{!! Form::submit("Guardar", [
				'class' => 'input__submit userEvent__btn userEvent__columns--btn',
				'form'  => "update_event_form"
			]) !!}

		{!! Form::close() !!}

	</div>
