{{-- Modal crear sección --}}
<div v-if="create_section_modal_is_open" @click.stop="closeModal('create_section_modal')" class="modal__overlay">
	<div class="modal__container modal__container--xs" @click.stop="">
		<span class="modal__close" @click="closeModal('create_section_modal')">{!! file_get_contents('images/icon-close.svg') !!}</span>
		<div class="modal__container-scrollable">

			<div class="modal__message mb3-2m">
				{!! $web_event_select_section_instructions_copy !!}
			</div>

			<div class="modal__actions-container modal__actions-container--no-db">
				<div v-for="section in store.section_types">
					{!! Form::open([
						'method'		=> 'POST',
						'route'			=> ['user::events.template.sections.ajax.store',$user->name,$personal_event->slug],
						'role'			=> 'form' ,
						':id'			=> ' "addsection_"+section.id+"_form" ',
						'v-on:submit.prevent'	=> 	'post'
					]) !!}
						<input type="hidden" :form='"addsection_"+section.id+"_form"' name="section_type_id" :value="section.id">
						<input type="submit" :form='"addsection_"+section.id+"_form"' class="input__submit" :value="section.label">
					{!! Form::close() !!}
				</div>
			</div>
		</div>
	</div>
</div>
