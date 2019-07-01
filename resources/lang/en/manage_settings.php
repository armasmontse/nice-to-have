<?php

return [

    'create' => [

        'first_name' => [

            'label'         => 'Nombre',
            'placeholder'   => 'Nombre',

        ],

        'last_name' => [

            'label'         => 'Apellido',
            'placeholder'   => 'Apellido',

        ],

        'email' => [

            'label'         => 'Correo de usuario',
            'placeholder'   => 'info@nicetohave.net',

        ],

        'roles' => [

            'label'     => 'Rol',
            'select'    => 'Selecciona un rol',

        ],

        'save' => 'guardar',

    ],

    'success' => [

        'create'    => 'La configuración ha sido creada',
        'update'    => 'La configuración ha sido actualizada',
        'trash'     => 'La configuración ha sido borrada',
        'recovery'  => 'La configuración ha sido recuperada',

    ],

    'error' => [
        'noexist'   => 'La configuración no existe',
        'cantsave'  => 'La conifguración no se pudo guardar',
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
    ],

    'shipment' => [
        'title' => 'Envíos',
        'origin-address'    => [
            'street-1'  => [
                'placeholder'   => 'Calle y número',
                'label'         => 'Street 1:',
                'helper'        => 'Primera linea de dirección de envío',
            ],
            'street-2'  => [
                'placeholder'   => 'Número interior, suite, fraccionamiento o delegación',
                'label'         => 'Street 2:',
                'helper'        => 'La segunda linea para la dirección de envío',
            ],
            'street-3'  => [
                'placeholder'   => 'Colonia',
                'label'         => 'Street 3:',
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

    'general' => [
        'save'  => 'guardar',
    ]
];
