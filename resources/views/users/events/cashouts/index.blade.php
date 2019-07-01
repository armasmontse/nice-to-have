@extends('layouts.client', ['body_id'	=> 	'update-event-vue'])

@section('title')
    | Retirar Efectivo
@endsection

@section('content')
	<div class="grid__row userEvent">
		@include('users.events.general.head')

		<div class="grid__container userEvent__columns">
			
			@include('users.events.cashouts.banking')
			
			@include('users.events.cashouts.summary')

		</div>

	</div>
@endsection

@section('vue_store')
	 <script>
	 	mainVueStore.types = mainVueStore.ajaxData({ get: '{{route('client::micro_services.types.index')}}'})
	 	mainVueStore.subtypes = mainVueStore.ajaxData({ get: '{{route('client::micro_services.subtypes.index')}}'})
	 </script>
@endsection
