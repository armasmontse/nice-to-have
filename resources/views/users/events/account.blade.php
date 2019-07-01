@extends('layouts.client', ['body_id'	=> 	'update-event-vue'])

@section('title')
    | Estado de Cuenta
@endsection

@section('content')

	<div class="grid__row userEvent">
		@include('users.events.general.head')
		@include('users.events.account.summary')
		@include('users.events.account.movements')
	</div>
	
	@include('users.events.profile.modals')

@endsection

@section('vue_store')
	 <script>
	 	mainVueStore.types = mainVueStore.ajaxData({ get: '{{route('client::micro_services.types.index')}}'})
	 	mainVueStore.subtypes = mainVueStore.ajaxData({ get: '{{route('client::micro_services.subtypes.index')}}'})
	 </script>
@endsection
