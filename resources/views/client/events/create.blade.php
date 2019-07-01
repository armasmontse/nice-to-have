@extends('layouts.client', ['body_id'	=> 	'create-event-vue'])

@section('title')
    | Crea tu evento
@endsection

@section('content')
<div class="grid__row create-event__row" v-bind:style="{backgroundImage: 'url('+currentImage+')'}">

    <div class="grid__container create-event__container">
        <div class="grid__col-1-1 grid__col-1-1--sm">
        	<div v-if="notNewEvent(store.new_event)">
	        	<div v-if="step === 2">@include('client.events.steps.step2')</div>
	        	<div v-if="step === 3">@include('client.events.steps.step3')</div>
	        	<div v-if="step === 4">@include('client.events.steps.step4')</div>
        	</div>
        	<div v-else>
	        	<div>@include('client.events.steps.step5')</div>
        	</div>
        </div>
    </div>

</div>

{!! Form::open([
		'method'                => 'post',
		'route'                => ['user::events.store', $user->name],
		'role'                  => 'form' ,
		'id'                    => 'create_event_form',
		'class'                 => ''
	]) !!}
	<input type="hidden" name="type_id" form="create_event_form" v-model='step_2.event_type'>
	<input type="hidden" name="subtype_id" form="create_event_form" v-model='step_2.type_variation'>
	<input type="hidden" name="name" form="create_event_form" v-model='step_3.event_name'>
	<input type="hidden" name="feted_names" form="create_event_form" v-model='step_3.event_people'>
	<input type="hidden" name="date" form="create_event_form" v-model='step_3.event_date'>
	<input type="hidden" name="exclusive" form="create_event_form" v-model='step_4.is_exclusive'>
	<input type="hidden" name="accept" form="create_event_form" value="1" v-if='step_4.accepted_terms'>
{!! Form::close() !!}

@endsection

@section('head_extras')
	    {!! Html::style('css/datepicker-jquery-ui.min.css')!!}
	    {!! Html::script('js/datepicker-jquery-ui.min.js')!!}
@endsection

@section('vue_store')
	 <script>
	 	mainVueStore.types = mainVueStore.ajaxData({ get: '{{route('client::micro_services.types.index')}}'})
	 	mainVueStore.subtypes = mainVueStore.ajaxData({ get: '{{route('client::micro_services.subtypes.index')}}'})
	 	mainVueStore.new_event = {!! $new_event != null ? $new_event :  '{}' !!}

	 	mainVueStore.view_images = {!! json_encode($images) !!}

	 </script>
@endsection
