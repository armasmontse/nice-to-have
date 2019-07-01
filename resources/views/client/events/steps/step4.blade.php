<div class="grid__box create-event__box">
	<div class="create-event__title-container">
		<h2 class="create-event__title">Términos y condiciones</h2>
		<div class="create-event__p">
			{!! $create_event_phase_4_copy !!}
		</div>
		<p class="create-event__step create-event__step--small">Paso 4 de 5</p>
	</div>
	<div class="create-event__title-container">
		<div class="create-event__p create-event__p--mb-sm">
			{!! $create_event_phase_4_exclusiveness_copy !!}
		</div>
	</div>

		<div class="create-event__input-container">
			<div class="create-event__checkbox-container">
				<label for="descuento" class="create-event__checkbox-label">
					<input id="descuento"
						class="create-event__checkbox create-event__checkbox--radio"
						name="descuento"
						type="radio"
						value="1"
						v-model="step_4.is_exclusive">
					Mesa de regalos única
				</label>

				<label for="no-descuento" class="create-event__checkbox-label">
					<input  id="no-descuento"
						class="create-event__checkbox create-event__checkbox--radio"
						name="no-descuento"
						type="radio"
						value="0"
						v-model="step_4.is_exclusive">
					Tengo más mesas de regalos
				</label>
			</div>
		</div>
		<div class="create-event__checkbox-container">
			<label for="tyc" class="create-event__label mb0">
				<input id="tyc"
					name="tyc"
					type="checkbox"
					v-model="step_4.accepted_terms">
				Acepto <a href="{{route("client::pages.show","terminos-y-condiciones") }}" style="text-decoration: underline" target="_blank">Términos y condiciones</a>
			</label>
		</div>

		<div class="create-event__button-container">
			<button class="input__submit" name="button" @click.stop.prevent="goToStep(5)">siguiente</button>
		</div>
	</div>
