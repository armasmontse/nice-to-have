<?php
return [

	'success' => [
		'assistance'			=> 'Gracias, hemos confirmado tu asistencia.',
		'create'				=> 'El evento se ha creado con éxito',
		'publish'				=> 'El evento se ha activado con éxito',
		'update'				=> 'La información del evento se ha guardado con éxito',
		'update_address'		=> 'Los datos de envío de regalos se han guardado con éxito',
		'finish'				=> 'Tu evento se ha cerrado exitosamente',
		'change_colors_palette'	=> 'Se recomienda cambiar los colores anteriores por los de la nueva paleta elegida.'
	],
	'errors' => [
		'event_closed'		=> 'El evento ya se encuentra cerrado.',
		'cant_create'		=> 'EL evento no pudo ser creado',
		'cant_publish'		=> 'EL evento no pudo ser activado',
		'no_template_view'	=> 'Por favor selecciona un diseño web primero'
	],
	'templates' => [
		'timer_days'	=> 'días',
		'timer_hours'	=> 'horas',
		'timer_mins'	=> 'minutos',
		'info_ttl'		=> 'Confirma tu asistencia',
		'info_rsvp'		=> 'Por favor revisa en tu invitación cuántos lugares te fueron asignados.',
		'rsvp_email'	=> 'Correo Electrónico',
		'rsvp_names'	=> 'Nombre y apellido de los asistentes',
		'rsvp_help'		=> '*Separa cada nombre con una coma',
		'schedule_ttl'	=> 'Agenda',
	],
	'validations' => [
		'html'	=> [
			'required'	=> 'El texto de portada es obligatorio.',
			'string'	=> 'El texto de portada debe contener solo letras y números.'
		],
		'background_color'	=> [
			'required'	=> 'El color de fondo es obligatorio.',
			'string'	=> 'El color de fondo debe ser uno válido.'
		],
		'image_background_color'	=> [
			'required'	=> 'El color de portada es obligatorio.',
			'string'	=> 'El color de portada debe ser válido.'
		],
	],
	'text' => [

		'html'	=> [
			'required'	=> 'El contenido es obligatorio.',
			'string'	=> 'El contenido debe comprender solo letras y números.'
		],

	]
];
