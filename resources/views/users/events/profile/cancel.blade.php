
	@if ( $personal_event->is_draft || $personal_event->is_publish )

		<div class="userEvent__columns--block">
			<p class="userEvent__title">Cancelar Evento</p>
			<div class="userEvent__paragraph userEvent__columns--paragraph">
				{!!  $event_profile_cancel_event_copy!!}
			</div>
		</div>

	@endif
