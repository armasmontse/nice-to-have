<?php
return [

	'success' => [
		'assistance'			=> 'Thank you, assistance confirmed.',
		'create'				=> 'The event was created successfully.',
		'publish'				=> 'The event was activated successfully.',
		'update'				=> 'The event information was saved successfully.',
		'update_address'		=> 'The gifts shipping information was saved successfully.',
		'finish'				=> 'The evento was successfully',
		'change_colors_palette'	=> 'It is recommended to change the previous colors to those of the new chosen palette.'
	],
	'errors' => [
		'event_closed'  	=> 'The event is already closed.',
		'cant_create'   	=> 'The event could not be created.',
		'cant_publish'  	=> 'The event could not be ractivated.',
		'no_template_view'	=> 'Please select a web design first.'
	],
	'templates' => [
		'timer_days'	=> 'days',
		'timer_hours'	=> 'hours',
		'timer_mins'	=> 'minutes',
		'info_ttl'		=> 'RSVP Please',
		'info_rsvp'		=> 'Please check in your invitation how many places you were assigned.',
		'rsvp_email'	=> 'E-Mail',
		'rsvp_names'	=> 'First & last names of the attendees',
		'rsvp_help'		=> '*Separate each name with a comma',
		'schedule_ttl'	=> 'Schedule',
	],
	'validations' => [
		'html'	=> [
			'required'	=> 'The cover page text is required.',
			'string'	=> 'The cover page text must contain only letters and numbers.'
		],
		'background_color'	=> [
			'required'	=> 'The background color is required.',
			'string'	=> 'The background color must be valid.'
		],
		'image_background_color'	=> [
			'required'	=> 'The cover page color is required.',
			'string'	=> 'The cover page color must be valid.'
		],
	]
];
