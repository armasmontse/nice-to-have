
	<div class="userEvent__columns--block">

			{!! Form::open([
                        'method'             => "patch",
                        'route'              => ["user::events.address",$user->name, $personal_event->slug],
                        'role'               => 'form' ,
                        'id'                 => "update_address_event_form",
                        'class'              => '',
                 ]) !!}	
				@include('client.checkout.partials.shipping-address',[
					"contact_name"  => old("address.contact_name") ?? ($address ? $address->contact_name :  $user->full_name),
					"email"         => ($address) ? $address->email :  old("address.email"),
					"phone"         => ($address) ? $address->phone :  old("address.phone"),
					"street1"       => ($address) ? $address->street1 :  old("address.street1"),
					"street2"       => ($address) ? $address->street2 :  old("address.street2"),
					"street3"       => ($address) ? $address->street3 :  old("address.street3"),
					"zip"           => ($address) ? $address->zip :  old("address.zip"),
					"city"          => ($address) ? $address->city :  old("address.city"),
					"state"         => ($address) ? $address->state :  old("address.state"),
					"country_id"    => ($address) ? $address->country_id :  old("address.country_id"),
					"references"    => ($address) ? $address->references :  old("address.references"),
					"form"			=> "update_address_event_form",	
					"title"			=> "Datos de Envío de Regalos"	
				])			
                 {!! Form::submit("Guardar", [
                      'class' => 'input__submit userEvent__btn userEvent__columns--btn',
                      'form'  => "update_address_event_form"
                  ]) !!}
	
		{!! Form::close() !!}

	</div>
