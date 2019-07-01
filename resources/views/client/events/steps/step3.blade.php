
<div class="grid__box create-event__box">
	<div class="create-event__title-container">
		<h2 class="create-event__title">Información</h2>
		<div class="create-event__p">
			{!! $create_event_phase_3_copy !!}
		</div>
		<p class="create-event__step create-event__step--small">Paso 3 de 5</p>
	</div>

		<div>
			<p class="create-event__label create-event__label--small">Información de tu Evento</p>
			<div class="create-event__input-container">

				<input class="input"
					type="text"
					placeholder="Nombre del evento"
					name=""
					id="event_name"
					v-model="step_3.event_name">
				<p class="create-event__p--help">Esta información aparecerá como título en la página web de evento.</p>
			</div>

			<div class="create-event__input-container">
				<input class="input"
					type="text"
					placeholder="Nombre del o de los festejados"
					name=""
					id="event_people"
					v-model="step_3.event_people">
				<p class="create-event__p--help">Separa cada nombre con una coma.</p>
			</div>
			<div class="relative create-event__input-container">
				<div class="relative z-0">{{-- zindex para la flecha --}}
					<input class="input create-event__input--transparent jq-datepicker_JS"
						type="text"
						name=""
						id="event_date"
						placeholder="Fecha del evento (aaaa-mm-dd)"
						@click="datePickerOnFocus"
						@focusin="datePickerOnFocus"
						@change="unFlip" {{-- del arrow del input --}}
						@focusout="unFlip">
					<span :class="{'create-event__flippable-svg' : arrow_is_flipped}">
						{!! file_get_contents('images/flecha-select.svg') !!}
					</span>
				</div>
				<p class="create-event__p--help">La mesa de regalos tiene una vigencia máxima de 3 meses después de la fecha del evento.</p>
			</div>
		</div>

		<div class="create-event__button-container">
			<button class="input__submit" name="button" @click.stop.prevent="goToStep(4)">siguiente</button>
		</div>
	</div>
