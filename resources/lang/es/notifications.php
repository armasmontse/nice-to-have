<?php

return [

    // Auth

    'activation_account' => [
        'subject'   => 'Bienvenido a NICE TO HAVE',
        // 'copy'      => App\Setting::getEmailCopy('register'),
        'action'    => 'Activar cuenta',
    ],

    'reset_password' => [
        'subject'   => 'Restablecer contraseña',
        'copy'      => 'Olvidaste o perdiste tu contraseña, recupérala dando click al botón debajo.',
        'action'    => 'Restablecer contraseña',
    ],

    // Users

    'update_password'    => [
        'subject'   => 'Tu contraseña ha cambiado',
        'copy'      => 'Recientemente notamos que tu contraseña ha cambiado, si no reconoces este cambio por favor contacta a soporte técnico, en caso contrario ignora este mensaje',
        'action'    => '',
    ],

    'update_mail'    => [
        'subject'   => 'Tu mail ha cambiado',
        'copy'      => 'Recientemente notamos que tu mail ha cambiado, si no reconoces este cambio por favor contacta a soporte técnico, en caso contrario ignora este mensaje',
        'action'    => '',
    ],

    // Users.Shop

    'billing_success_request' => [
        'subject'   => 'Solicitud de facturación a nicetohave.com.mx',
        'action'    => 'Tu factura ha sido solicitada correctamente'
    ],

    'billing_update_status' => [
        'subject'   => 'Actualización de estatus de facturación',
        'copy'      => 'El estatus de la factura fue actualizada correctamente',
        'action'    => 'Ver estatus'
    ],

    'buy_success' => [
        'subject'   => 'Tu pedido nicetohave.com.mx #:BAG_KEY',
        // 'copy'      =>  Setting::getEmailCopy('purchase'),
        'action'    => 'Detalles del pedido',
    ],

    'cancel_bag' => [
        'subject'   => 'Tu compra #:BAG_KEY en nicetohave.com.mx ha sido cancelada.',
        'copy'      => 'Este mail es para informarte que tu compra en NICE TO HAVE #:BAG_KEY ha sido cancelada debido a :bag_status_info. ',
        'action'    => '',
    ],

    'PresentNotification' => [
        'subject'   => ':Name, nicetohave.com.mx tiene una sorpresa para ti.',
        'greeting'  => '¡Felicidades!',
        'copy'      => ':User_name te ha hecho un regalo a través de nicetohave.com.mx, haz click en el siguiente enlace y mira lo que muy pronto recibirás.',
        'action'    => '¡Quiero ver mis regalos!',
        'farewell'  => '',
    ],

    'update_bag_status'    => [
        'subject'   => 'Se ha actualizado el estatus de tu compra #:BAG_KEY',
        'copy'      => 'La compra #:BAG_KEY cambió su estatus a :Bag_status <br/> :Status_info',
        'action'    => 'Revisa el estatus de tu compra aquí',
    ],

    // Users.Events

	'cash_outs_success_request'    => [
		'subject'   => 'Retiro de efectivo en nicetohave.com.mx del evento #:EVENT_KEY',
		// 'copy'      => Setting::getEmailCopy('cash_out'),
		'action'    => 'Ver detalles',
	],

    'cash_outs_update_status' => [
        'subject'   => 'El estatus de tu retiro de efectivo del evento #:EVENT_KEY ha sido actualizado',
        'copy'      => 'El estatus de tu retiro de efectivo del evento #:EVENT_KEY se ha actualizado. Mira el nuevo estatus dando click al botón de abajo.',
        'action'    => 'Ver detalles',
    ],

    'close_event' => [
        'subject'   => 'El evento :event_name ha sido cerrado exitosamente',
        'copy'      => 'El evento :event_name con código #:EVENT_KEY ha sido cerrado. Por favor termina tu compra, es indispensable que termines el proceso para poder seguir comprando productos en nuestra tienda.',
        'action'    => 'Terminar compra',
    ],

    'confirm_attendance' => [
        'subject'   => ':Assistants ha confirmado su asistencia a tu evento #:EVENT_KEY|:Assistants han confirmado su asistencia a tu evento #:EVENT_KEY',
        'copy'      => ':Assistants ha confirmado su asistencia!|:Assistants han confirmado su asistencia!',
        'action'    => ''
    ],

    // Missing to check;

    'create_event' => [
        'subject'  => 'Tu evento se ha creado exitosamente',
        'copy'     => 'Has creado un evento en nicetohave.com.mx',
        'action'   => 'Ver estatus de evento'
    ],

    'event_gift'       => [
        'subject'   => ':Name, alguien ha hecho un regalo para tu evento #:EVENT_KEY en nicetohave.com.mx!',
        'greeting'  => '¡Felicidades :Name!',
        'copy'      => ':User_name te ha hecho un regalo a través de nicetohave.com.mx, haz click en el siguiente enlace y mira lo que muy pronto recibirás.',
        'action'    => '¡Quiero ver mis regalos!',
        'farewell'  => '',
    ],

    'finish_event_checkout' => [
        'subject'   => 'El periodo de regalos de tu evento ha finalizado, echa un ojo a tus regalos.',
        'message'   => 'El periodo de regalos de tu evento ha finalizado, ingresa a tu cuenta, echa un vistazo a los regalos que más te gusten y finaliza la compra.',
        'action'    => 'Mira tus regalos'
    ],

    'thanks_for_confirm_attendance' => [
        'subject'   => 'Gracias por confirmar su asistencia.',
        'greeting'  => 'Hola ',
        'message'   => 'Gracias por confirmar su asistencia, :Feted_names los esperan a todos el :EVENT_DAY',
        'action'    => 'Ver evento'
    ],

    // Mail

    'thanks_for_contact' => [
        'subject'   => 'Información de contacto',
        'greeting'  => 'Hola ',
        'message'   => 'Gracias por ponerte en contacto con nosotros. Hemos recibido tu correo y muy pronto te daremos respuesta.',
    ],

    'contact_mail' => [
        'subject'   => 'Información de contacto nicetohave.com.mx [:email]',
        'greeting'  => 'Información de contacto nicetohave.com.mx'
    ],

    // Admin.Shop

    'admin_buy_success'    => [
        'subject'   => 'Tu pedido nicetohave.com.mx #:BAG_KEY',
        'greeting'  => 'Confirmación de pedido',
        'copy'      => '',
        'action'    => 'Detalles del pedido',
        'farewell'  => '',
    ],

    'admin_billing_success'    => [
        'subject'   => 'Solicitud de facturación a nicetohave.com.mx',
        'action'    => 'Se ha solicitado una factura'
    ],

    // Admin.Events

    'admin_create_event'    => [
        'subject'  => 'Se ha creado un evento exitosamente',
        'copy'     => 'Se ha dado de alta un nuevo evento en nicetohave.com.mx',
        'action'   => 'Ver estatus de evento'
    ],

    'admin_close_event'    => [
        'subject'   => 'El evento #:EVENT_KEY ha sido cerrado',
        'copy'      => 'El evento #:EVENT_KEY ha sido cerrado.',
        'action'    => 'Ver bolsa de evento',
    ],

    'admin_cashout_success'    => [
        'subject'   => 'Retiro de efectivo en nicetohave.com.mx del evento #:EVENT_KEY',
		'copy'      => '',
		'action'    => 'Ver detalles',
    ],
];
