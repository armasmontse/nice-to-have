
	<div class="userEvent__columns--block">
		<p class="userEvent__title">Diseño Web de Evento</p>
		<div class="userEvent__paragraph userEvent__columns--paragraph">
			{!! $event_profile_web_design_invitation_copy !!}
		</div>
		<center>
		@if ($personal_event->is_draft)
			<a href="{{ route('user::events.template.index',[$user->name,$personal_event->slug]) }}" class="input__submit userEvent__columns--btn userEvent__btn button black">Personalizar página web</a>
		@else ($personal_event->is_publish && !$personal_event->template_is_publish)
			<a href="{{ route('user::events.template.index',[$user->name,$personal_event->slug]) }}#publish_template" class="input__submit userEvent__columns--btn userEvent__btn button black">Personalizar página web</a>
		@endif
		</center>
		<div class="userEvent__paragraph userEvent__columns--paragraph">
			{!! $event_profile_web_design_clarification_copy !!}
		</div>
	</div>
