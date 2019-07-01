<div class="grid__box create-event__box">
	<div class="create-event__title-container">
		<h2 class="create-event__title">Crea tu evento</h2>
		<div class="create-event__p">
			{!! $create_event_phase_2_copy !!}
		</div>
		<p class="create-event__step create-event__step--small">
			Paso 2 de 5
		</p>
	</div>
		<div class="">

			<label {{-- for="event_type" --}}>
				<p class="create-event__label create-event__label--small">Selecciona un tipo de evento</p>
				<div class="input__select-container create-event__select-container">
					<select class="input__select create-event__select" name="event_type" id="event_type" v-model="step_2.event_type">
						<option value="">Tipo de evento</option>
						<option value="" v-if="!store.types.data" disabled>Cargando tipos de evento</option>
						<option :value="option.id" v-for="option in store.types.data" v-text="option.es_label"></option>
					</select>
					{!! file_get_contents('images/flecha-select.svg') !!}
				</div>
			</label>

			<br><br>
			<br><br>

			<label {{-- for="event_subtype" --}}>
			<p class="create-event__label create-event__label--small">Selecciona una variación</p>
				<div class="input__select-container create-event__select-container">
					<select class="input__select create-event__select" name="event_type" id="event_subtype" v-model="step_2.type_variation">
						<option value="">Variación</option>
						<option value="" v-if="availableSubtypes.length == 0" disabled>Selecciona up tipo de evento</option>
						<option :value="option.id" v-for="option in availableSubtypes" v-text="option.label"></option>
					</select>
					{!! file_get_contents('images/flecha-select.svg') !!}
				</div>
			</label>
		</div>

		<div class="create-event__button-container">
			<button class="input__submit" name="button" @click.stop.prevent="goToStep(3)">siguiente</button>
		</div>

	</div>
