<?php

return [

    'success' => [

        'create'    => 'La configuración ha sido creada',
        'update'    => 'La configuración ha sido actualizada',
        'trash'     => 'La configuración ha sido borrada',
        'recovery'  => 'La configuración ha sido recuperada',

    ],

    'error' => [
        'noexist'   => 'La configuración no existe',
        'cantsave'  => 'La configuración no se pudo guardar',
        'canteditthisuser' => 'No es posible editar este usuario',
        'dontUpdateUser' => 'No es posible actualizar este usuario',
        'cantedityoursroles' => 'No es posible editar tu rol',
        'canttrashthisuser' => 'No es posible borrar este usuario',
        'canttrashyourself' => 'No es posible borrar tu usuario',
        'problemtotrashthisuser' => 'Hubo un problema al borrar este usuario',
        'usernotintrash' => 'Este usuario no se ha eliminado',
        'cantrecoverthisuser' => 'No es posible recuperar este usuario',
        'problemtorecoverthisuser' => 'Hubo un problema al recuperar este usuario',
    ],

    'description' => [
        'title' => 'Información del sitio',
        'image-label' => 'Imágen destacada para SEO del sitio, (280x150px)',
        'es'   => [
            'label'         => 'Descripción del sitio:',
        ]
    ],

    'blog' => [
        'title' => 'Blog',
        'url'   => [
            'placeholder'   => 'Ej. https://www.tumblr.com/nicetohave/',
            'label'         => 'Link:',
            'helper'        => 'Este link estará conectado con la imagen de Moodboard en About',
        ]
    ],

    'social' => [
        'title'     => 'Redes sociales',
        'facebook'  => [
            'placeholder'   => 'Ej. https://www.tumblr.com/nicetohave/',
            'label'         => 'Facebook:',
            'helper'        => 'Este link estará conectado con la forma de contacto del footer',
        ],
        'twitter'   => [
            'placeholder'   => 'Ej. https://www.tumblr.com/nicetohave/',
            'label'         => 'Twitter:',
            'helper'        => 'Este link estará conectado con la forma de contacto del footer',
        ],
        'instagram' => [
            'placeholder'   => 'Ej. https://www.tumblr.com/nicetohave/',
            'label'         => 'Instagram:',
            'helper'        => 'Este link estará conectado con la imagen de instagram en About',
        ],
        'pinterest' => [
            'placeholder'   => 'Ej. https://www.tumblr.com/nicetohave/',
            'label'         => 'Pinterest:',
            'helper'        => 'Este link estará conectado con la forma de contacto del footer',
        ],
    ],
    'authentication' =>
    [
        'title'                     => 'Autenticación',
        'copys'                     => 'Copys de Autenticación',
        'main_register'             => 'Registro principal (Español)',
        'event_register'            => 'Registro de evento (Español)',
        'checkout_register'         => 'Registro de checkout (Español)',
        'login'                     => 'Inicio de sesión (Español)',
        'register_image'            => 'Imagen de registro (Español)',
        'login_image'               => 'Imagen de inicio de sesión (Español)',
        'event_register_image'      => 'Imagen de registro de evento (Español)',
        'checkout_register_image'   => 'Imagen de registro del checkout (Español)'
    ],
    'copys' =>
    [
        'title'                 => 'Copys del sitio',
        'create_event'  =>
        [
            'title'                 => 'Crea tu evento',
            'phase_2'               => 'Paso 2 (Español)',
            'phase_3'               => 'Paso 3 (Español)',
            'phase_4'               => 'Paso 4 (Español)',
            'phase_4_exclusiveness' => 'Paso 4 - Exclusividad (Español)',
            'phase_5'               => 'Paso 5 (Español)'
        ],
        'event_profile' =>
        [
            'title'                     => 'Perfil de evento',
            'header'                    => 'Encabezado (Español)',
            'web_design_invitation'     => 'Diseño web - Invitación (Español)',
            'web_design_clarification'  => 'Diseño web - Aclaración (Español)',
            'activate_event'            => 'Activar evento',
            'cancel_event'              => 'Cancelar evento',
            'close_event'               => 'Cerrar evento',
            'cash_withdrawal'           => 'Retiro de efectivo (Español)',
            'shopping_cart'             => 'Encabezado de carrito (Español)',
            'checkout_alert'            => 'Alerta de checkout de no contar con mínimo (Español)',
            'popup_event_activated'     => 'Pop-up de evento correctamente activado',
            'popup_event_cancelled'     => 'Pop-up de cerrar evento'
        ],
        'web_event' =>
        [
            'title'                         => 'Web de evento',
            'header'                        => 'Encabezado (Español)',
            'change_color'                  => 'Advertencia de cambio de color (Español)',
            'new_section_instructions'      => 'Instrucciones para editar nuevas secciones (Español)',
            'publish_web_event'             => 'Publicar web de evento (Español)',
            'popup_web_event_published'     => 'Pop-up de web de evento correctamente publicado (Español)',
            'select_section_instructions'   => 'Pop-up de web de evento para seleccionar el tipo de sección (Español)'
        ],
        'message_and_gifts' =>
        [
            'title'         => 'Mensaje y regalos',
            'gift_registry' => 'Mesa de regalos (Español)'
        ],
        'cash_withdrawal' =>
        [
            'title'                         => 'Retirar Efectivo',
            'header'                        => 'Encabezado (Español)',
            'instructions'                  => 'Instrucciones para retirar dinero (Español)',
            'withdrawal_requested'          => 'Retiro ya solicitado (Español)',
            'fees'                   => 'Comisiones (Español)',
            'popup_withdrawal_requested'    => 'Pop-up de retiro de efectivo correctamente solicitado'
        ],
        'event_bags' =>
        [
            'title'                         => 'Carrito de evento',
            'header'                        => 'Encabezado (Español)',
			'popup_close_empty_bag'			=> 'Pop-up de cerrar carrito en vacío.'
        ],
        'event_checkout' =>
        [
            'title'                         => 'Checkout de evento',
            'alert_not_min'                 => 'Alerta de no contar con mínimo para checkout(Español)',
        ],

        'checkout' =>
        [
            'title'             => 'Checkout',
            'event_send'        => 'Envío de evento (Español)',
            'instructions'      => 'Instrucciones de SPEI    (Español)',
            'note_instructions' => 'Nota de instrucciones (Español)'
        ],
        'thank_you_page' =>
        [
            'title'                 => 'Página de agradecimiento',
            'gratitude_alert'       => 'Alerta de agradecimiento por comprar (Español)',
            'ramaining_products'    => 'Alerta de productos restantes en carrito (Español)'
        ],
        'search' =>
        [
            'title'             => 'Búsqueda',
            'search_message'    => 'Mensaje de búsqueda',
			'without_results'	=> 'Sin resultados de búsqueda'
        ],
        'shopping_carts' =>
        [
            'title'                         => 'Carritos',
            'personal_shopping_cart_empty'  => 'Carrito personal vacío (Español)',
            'event_shopping_cart_empty'     => 'Carrito de evento vacío (Español)',
            'delete_product'                => 'Pop-up de eliminar producto de carrito (Español)'
        ]
    ],

    'mail' => [
        'title' => 'Correo',
        'contact'   => [
            'placeholder'   => 'Ej. info@nicetohave.net',
            'label'         => 'Correo de contacto:',
            'helper'        => '',
        ],
        'system'   => [
            'placeholder'   => 'Ej. hola@nicetohave.net',
            'label'         => 'Correo del sistema:',
            'helper'        => 'Correo con el que se enviarán los mails de registro, etc.',
        ],
        'notifications'   => [
            'placeholder'   => 'Ej. hola@nicetohave.net',
            'label'         => 'Correo de notificaciones:',
            'helper'        => 'Correo con el que se enviarán los mails de notificaciones',
        ],
        'register_copy' => [
            'es' => [
                'label'         => 'Copy para mail de registro (español):',
            ],
            'en' => [
                'label'         => '(ingles):',
            ],
        ],
		'cash_out_copy' => [
			'es' => [
				'label'         => 'Copy para solicitud de retiro de efectivo (español):',
			],
			'en' => [
				'label'         => '(ingles):',
			],
		],
        'purchase_copy' => [
            'es' => [
                'label'         => 'Copy para mail de compra (español):',
            ],
            'en' => [
                'label'         => '(ingles):',
            ],
        ],
        // 'thanks_copy' => [
        //     'es' => [
        //         'label'         => 'Copy para página de agradecimiento (español):',
        //     ],
        //     'en' => [
        //         'label'         => '(ingles):',
        //     ],
        // ],
        'mail_greeting' => [
            'es' => [
                'label'         => 'Saludo (español):',
            ],
            'en' => [
                'label'         => 'Saludo (ingles):',
            ],
        ],
        'mail_farewell' => [
            'es' => [
                'label'         => 'Despedida (español):',
            ],
            'en' => [
                'label'         => 'Despedida (ingles):',
            ],
        ],
    ],

    'shipment' => [
        'title' => 'Envíos',
        'origin-address'    => [
            'street-1'  => [
                'placeholder'   => 'Calle y número',
                'label'         => 'Calle y número:',
                'helper'        => 'Primera linea de dirección de envío',
            ],
            'street-2'  => [
                'placeholder'   => 'Número interior, suite, fraccionamiento o delegación',
                'label'         => 'Número interior, suite, fraccionamiento o delegación',
                'helper'        => 'La segunda linea para la dirección de envío',
            ],
            'street-3'  => [
                'placeholder'   => 'Colonia',
                'label'         => 'Colonia',
                'helper'        => 'La tercera linea para la dirección de envío',
            ],
            'city'  => [
                'placeholder'   => 'Ej. Ciudad de México',
                'label'         => 'Ciudad',
                'helper'        => 'La ciudad de la dirección de envío',
            ],
            'state'  => [
                'placeholder'   => 'Ej. Distrito Federal',
                'label'         => 'Estado:',
                'helper'        => 'El estado de la dirección de envío',
            ],
            'country'  => [
                'placeholder'   => 'Ej. México',
                'label'         => 'País:',
                'helper'        => 'El país de la compañia',
            ],
            'zip'  => [
                'placeholder'   => 'Ej. 01234',
                'label'         => 'Código postal:',
                'helper'        => 'Código postal de la dirección',
            ],
        ],
        'average-weight'    => [
            'placeholder'   => 'Ej. 10',
            'label'         => 'Peso promedio:',
            'helper'        => 'Peso promedio de cada envío en kilogramos',
        ],
        'minimal-clothing'  => [
            'placeholder'   => 'Ej. 5',
            'label'         => 'Prendas mínimas:',
            'helper'        => 'Prendas mínimas por caja',
        ],
    ],

    'exchange_rate' => [
        'title'     => 'Tipo de cambio',
        'US'   => [
            'currency' => [
                'placeholder'   => 'Ej. USD',
                'label'         => 'Tipo de moneda (US):',
                'helper'        => '',
            ],
            'exchange' => [
                'placeholder'   => 'Ej. 19.56',
                'label'         => 'Tipo de cambio (US):',
            ],
        ],
    ],

    'estafeta_zones' => [
        'title'     => 'Costos zonas de estafeta',
        'base_cost'   => [
            'placeholder'   => '30.50',
            'label'         => 'Costo base:',
            'helper'        => 'Ingresar el costo en pesos mexicanos',
        ],
        'additional_cost'   => [
            'placeholder'   => '6.50',
            'label'         => 'Medio adicional:',
            'helper'        => 'Ingresar el costo en pesos mexicanos',
        ],
    ],

    'card_cost' => [
        'title'         => 'Tarjeta de regalo para eventos',
        'placeholder'   => '12.50',
        'label'         => 'Costo:',
        'helper'        => '',
    ],

	'cashout_min_amount' => [
		'title'         => 'Retiros de efectivo',
		'placeholder'   => '110',
		'label'         => 'Monto mínimo para solicitar un retiro de efectivo:',
		'helper'        => '',
	],

	'cash_out_fees' => [
		'title'         => 'Comisiones por retiros de efectivo',

		'exclusive'	=> [
			'placeholder'   => '5',
			'label'         => 'Porcentaje para mesas de regalos exclusivas:',
			'helper'        => '',
		],
		'not_exclusive'	=> [
			'placeholder'   => '7.5',
			'label'         => 'Porcentaje para mesas de regalos no exclusivas:',
			'helper'        => '',
		],
	],

	'checkout_min' => [
		'title'         => 'Porcentaje para retiro de productos',
		'placeholder'   => '30',
		'label'         => 'Porcentaje:',
		'helper'        => '',
	],

    'event_expiration' => [
        'title'         => 'Expiración de eventos después de realizado',
        'placeholder'   => '3',
        'label'         => 'Meses para que expire un evento:',
        'helper'        => '',
    ],

	'event_create_images' => [
        'title'         => 'Imágenes de fondo de creación de eventos',
    ],

    'event_search_image' => [
        'title'         => 'Imágen de fondo de búsqueda de eventos',
    ],

    'general' => [
        'save'  => 'guardar',
    ]
];
