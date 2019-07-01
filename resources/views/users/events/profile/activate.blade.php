	@if ( $personal_event->is_publish )

		<div id="activate_event" class="userEvent__columns--block">

			{{-- Cerrar Evento --}}
			<p class="userEvent__title">Cerrar Evento</p>
			<div class="userEvent__paragraph userEvent__columns--paragraph">
				{!! $event_profile_close_event_copy !!}
			</div>
			<p class="userEvent--line userEvent__columns--line">Estatus del Evento: {{ $personal_event->eventStatus->label }}</p>
			{!! Form::open([
				'method'	=> "patch",
				'route'		=> ["user::events.finish",$user->name, $personal_event->slug],
				'role'		=> 'form' ,
				'id'		=> "close_event_form",
				'class'		=> '',
			]) !!}

				{!! Form::submit("Cerrar Evento", [
					'class' => 'input__submit userEvent__btn userEvent__columns--btn',
					'form'  => "close_event_form",
					'@click.prevent' => 'closeEventOpenModal'
				]) !!}

			{!! Form::close() !!}

		</div>

	@elseif ( $personal_event->is_draft )

		<div id="cancel_event" class="userEvent__columns--block">

			{{-- Activar Evento --}}
			<p class="userEvent__title">Activar Evento</p>
			<div class="userEvent__paragraph userEvent__columns--paragraph">
				{!! $event_profile_activate_event_copy !!}
			</div>
			<p class="userEvent--line userEvent__columns--line">Estatus del Evento: {{ $personal_event->eventStatus->label }}</p>
			{!! Form::open([
				'method'	=> "patch",
				'route'		=> ["user::events.publish",$user->name, $personal_event->slug],
				'role'		=> 'form' ,
				'id'		=> "active_event_form",
				'class'		=> '',
			]) !!}
				
				<center>
				{!! Form::submit("Activar Evento", [
					'class' => 'input__submit userEvent__btn userEvent__columns--btn black',
					'form'  => "active_event_form",
				]) !!}
				</center>

			{!! Form::close() !!}

		</div>

	@endif
