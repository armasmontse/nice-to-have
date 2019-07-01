{!! Form::open([
	'method'             => "POST",
	'route'              => ["user::bank_accounts.store",$user->name],
	'role'               => 'form' ,
	'id'                 => "banking_event_form"
	]) !!}

	@include('users.events.general.banking-event-inputs', ['form'	=> 	'banking_event_form'])
	{!! Form::submit($btn_copy, [
		'class' => 'input__submit '. (isset($btn_class) ? $btn_class : "") .' userEvent__btn userEvent__columns--btn',
		'form'  => "banking_event_form"
	]) !!}

{!! Form::close() !!}
