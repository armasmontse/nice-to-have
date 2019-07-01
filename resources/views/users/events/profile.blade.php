@extends('layouts.client', ['body_id'	=> 	'update-event-vue'])

@section('title')
    | Perfil de Evento
@endsection

@section('content')
<div class="grid__row userEvent">

	@include('users.events.general.head')

	<div class="grid__container userEvent__columns">

		<div class="grid__col-1-2 checkout__col-1-2">
			<div class="checkout__box checkout__box-right">
				@include('users.events.profile.update')
				@include('users.events.profile.shipping')

				@include('users.events.profile.banking')
			</div>
		</div>

		<div class="grid__col-1-2 checkout__col-1-2">
			<div class="checkout__box checkout__box-left">
				@include('users.events.profile.web')
				@include('users.events.profile.activate')
				@include('users.events.profile.withdraw')
				@include('users.events.profile.finish')
				@include('users.events.profile.cancel')
			</div>
		</div>

	</div>

</div>
@include('users.events.profile.modals')
@endsection

@section('head_extras')
	    {!! Html::style('css/datepicker-jquery-ui.min.css')!!}
	    {!! Html::script('js/datepicker-jquery-ui.min.js')!!}
@endsection


@section('vue_store')
	 <script>
	 	mainVueStore.types = mainVueStore.ajaxData({ get: '{{route('client::micro_services.types.index')}}'})
	 	mainVueStore.subtypes = mainVueStore.ajaxData({ get: '{{route('client::micro_services.subtypes.index')}}'})
		mainVueStore.personal_event = {!! isset($personal_event) ? json_encode($personal_event) : '{}' !!}
		mainVueStore.publish_event = {!! session('publish_event') ? 'true' : 'false' !!}
		mainVueStore.event_hour = "{{$personal_event->date->format('H:i')}}"
		mainVueStore.finish_event = {!! session('finish_event') ? 'true' : 'false' !!}
		mainVueStore.publish_template_event = {!! session('publish_template_event') ? 'true' : 'false' !!}
		mainVueStore.states_and_mun = {!! json_encode($mexico_states_and_mun) !!}
		mainVueStore.selected_street2 = "{{$address ? $address->street2 : ''}}"
	 </script>
@endsection
