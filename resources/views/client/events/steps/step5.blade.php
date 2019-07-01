<div class="grid__box create-event__box">
	<div class="create-event__title-container">
		<h2 class="create-event__title">¡Ya está listo tu evento!</h2>
		<p class="create-event__step create-event__step--small">Paso 5 de 5</p>
	</div>

	<div class="create-event__input-container">
		<div class="create-event__p tac">
			{!! $create_event_phase_5_copy !!}
		</div>
	</div>

	<div class="create-event__button-container">
		<a :href="store.new_event.perfil_url" class="input__submit" name="button">Perfil de evento</a>
	</div>

</div>
