<div class="divisor mb3m"></div>

<div class="userEvent__box userEvent__box--sm flex-cont--sb flex-col mb3m">
	<div class="userEvent__box mb3m">
		<div class="input__checkbox-container">
			<input
				type="checkbox"
				id="visible-section"
				name="publish"
				form="{{$form}}"
				class="input__checkbox userEvent__publish-checkbox"
				v-model="selected_section.publish">
			<label class="userEvent__title" for="visible-section">Seccion visible en la web de evento</label>
			<p class="create-event__p--help">*Una vez que estés satisfecho con el contenido y el diseño de tu sección hazla visible para tus invitados</p>
		</div>
	</div>
	<div class="tac" v-if="selected_section.publish"><a href="{{ $personal_event->public_url }}" target="_blank" class="input__submit mb2-3m">Previsualizar web de evento</a></div>
	<div class="tac">
		<input type="submit" class="input__submit black" form="{{ $form }}" value="Guardar Cambios">
	</div>
</div>
