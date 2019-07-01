{{-- Modal activar --}}
		<div v-if="activated_event_modal_is_open" @click.stop="closeModal('activated_event_modal')" class="modal__overlay">
			<div class="modal__container modal__container--activated-event" @click.stop="">
				<span class="modal__close" @click="closeModal('activated_event_modal')">{!! file_get_contents('images/icon-close.svg') !!}</span>
				<div class="modal__container-scrollable">

					<div class="modal__message modal__message--mb-sm">
						{!! $event_profile_popup_event_activated_copy !!}
					</div>

					<div class="modal__actions-container modal__actions-container--centered">
						<span href="#" class="input__submit" @click="closeModal('activated_event_modal')">Ok</span>
					</div>
				</div>
			</div>
		</div>

{{-- Modal de evento publicado --}}
		<div v-if="published_event_modal_is_open" @click.stop="closeModal('published_event_modal')" class="modal__overlay">
			<div class="modal__container modal__container--published-event" @click.stop="">
				<span class="modal__close" @click="closeModal('published_event_modal')">{!! file_get_contents('images/icon-close.svg') !!}</span>
				<div class="modal__container-scrollable">
					<p class="modal__message modal__message--mb-sm">Tu web de evento ha quedado publicada.<br>Comparte tu url del evento para que tus invitados accedan a la información y empiecen a hacerteregalos.</p>
					<p class="modal__message modal__message--mb-md">www.XXXXXX.nicetohave.com</p>

					<div class="modal__actions-container modal__actions-container--centered">
						<span href="#" class="input__submit" @click="closeModal('published_event_modal')">Ok</span>
					</div>
				</div>
			</div>
		</div>
{{-- Modal eliminar --}}
		<div class="modal__overlay"
			v-if="close_event_modal_is_open"
			@click.stop="closeModal('close_event_modal')"
		>
			<div class="modal__container modal__container--close-event" @click.stop="">
				<span class="modal__close" @click="closeModal('close_event_modal')">{!! file_get_contents('images/icon-close.svg') !!}</span>
				<div class="modal__container-scrollable">
					<div class="modal__message">
						{!! $event_profile_popup_event_cancelled_copy !!}
					</div>

					<div class="modal__actions-container">
						<span class="input__submit" @click="closeModal('close_event_modal')">Cancelar</span>
						<span class="input__submit" @click="closeEvent('close_event_form')">Cerrar evento</span>
					</div>
				</div>
			</div>
		</div>
