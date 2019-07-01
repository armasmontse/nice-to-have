<?php

return [

    // Auth

    'activation_account' => [
        'subject'   => 'Welcome to NICE TO HAVE',
        // 'copy'      => App\Setting::getEmailCopy('register'),
        'action'    => 'Activate account',
    ],

    'reset_password' => [
        'subject'   => 'Restore password',
        'copy'      => 'Lost or forgot your password, click below to reset it.',
        'action'    => 'Restore password',
    ],

    // User

    'update_password' => [
        'subject'   => 'Your password has changed',
        'copy'      => 'Recently your password was changed. If it was you ignore this message on the contrary call techincal support',
        'action'    => '',
    ],

    'update_mail'    => [
        'subject'   => 'Your email has changed',
        'copy'      => 'Recently your email was changed. If it was you ignore this message on the contrary call techincal support',
        'action'    => '',
    ],

    // Users.Shop

    'billing_success_request' => [
        'subject'   => 'Billing Request',
        'action'    => 'Your billing is complently successfully'
    ],

    'billing_update_status' => [
        'subject'   => 'Update status billing',
        'copy'      => '',
        'action'    => 'Billing status was updated succesfully'
    ],

    'buy_success' => [
        'subject'   => 'Your purchase at nicetohave.com.mx #:BAG_KEY',
        // 'copy'      => Setting::getEmailGreeting(),
        'action'    => 'Purchase details',
    ],

    'cancel_bag'    => [
        'subject'   => 'Your purchase #:BAG_KEY in nicetohave.com.mx has been canceled',
        'greeting'  => 'hello!',
        'copy'      => 'This mail is for telling that your purchace in NICE TO HAVE #:BAG_KEY has been canceled. ',
        'action'    => '',
        'farewell'  => 'bye!',
    ],

    'PresentNotification'       => [
        'subject'   => 'nicetohave.com.mx have a surprise for you!',
        'greeting'  => '¡Congratulations :Name!',
        'copy'      => ':User_name make you a present through nicetohave.com.mx, click the next link and take a look about what you gonna get.',
        'action'    => '¡Wanna see my presents!',
        'farewell'  => '',
    ],

    'update_bag_status'    => [
        'subject'   => 'Your purchase #:BAG_KEY status has been updated',
        'greeting'  => 'hello!',
        'copy'      => [
            'This mail is for telling you that your purchase #:BAG_KEY status has been updated.',
            'Tracking code: :TRACKING_CODE',
            'Shipping Method: :METHOD',
            ':STATUS_INFO'
        ],
        'action'    => 'Check out the status of your purchase here',
        'farewell'  => 'bye!',
    ],

    // Users.Events

    'cash_outs_success_request'    => [
		'subject'   => 'Retiro de efectivo en nicetohave.com.mx del evento #:EVENT_KEY',
		'greeting'  => 'Confirmación de pedido',
		'copy'      => '',
		'action'    => 'Ver detalles',
		'farewell'  => '',
	],

    'cash_outs_update_status' => [
        'subject'   => 'The status of the cash out for your event #:EVENT_KEY has been updated',
        'greeting'  => 'hello!',
        'copy'      => 'The status of the cash out for your event #:EVENT_KEY has been updated. Look the new status clicking below.',
        'action'    => 'See cash out status',
        'farewell'  => 'bye!',
    ],

    'close_event' => [
        'subject'   => 'The event #:EVENT_KEY has been closed succesfully',
        'greeting'  => 'hello!',
        'copy'      => 'The #:EVENT_KEY has been closed. Please checkout your gifts.',
        'action'    => 'Finish purchase',
        'farewell'  => 'bye!',
    ],

    'confirm_attendance' => [
        'greeting'  => 'Hello!',
        'have'      => 'have',
        'has'       => 'has',
        'subject'   => 'confirm attendance to your event #:event_key',
        'copy'      => 'confirm attendance'
    ],

    'create_event' => [
        'subject'  => 'Your event had create succesfully',
        'copy'     => 'You had an event create',
        'action'   => 'See cash out status'
    ],

    'event_gift'       => [
        'subject'   => ':Name, somebody has make you a present to your event #:EVENT_KEY in nicetohave.com.mx !',
        'greeting'  => '¡Congratulations :Name!',
        'copy'      => ':User_name make you a present through nicetohave.com.mx, click the next link and take a look about what you gonna get.',
        'action'    => '¡Wanna see my presents!',
        'farewell'  => '',
    ],

    'finish_event_checkout' => [
        'subject'   => 'the period to gift of your event has expired, take a look to your gifts.',
        'message'   => 'the period to gift of your event has expired, login to your account, take a look to the gifts you like most and finish the purchase.',
        'action'    => 'Take a look to your gifts'
    ],

    'thanks_for_confirm_attendance' => [
        'subject'   => 'Thank you for confirm your attendance.',
        'greeting'  => 'Hello ',
        'message'   => 'Thank you for confirm your attendance, :feted_names wait for all of you at ',
        'action'    => 'Watch event'
    ],

    // Mail

    'thanks_for_contact' => [
        'subject'   => 'Re: Contact Information nicetohave.com.mx',
        'greeting'  => 'Hello ',
        'message'   => 'Thank you for contact us. We have received your mail and we will contact you soon enough.',
    ],

    'contact_mail' => [
        'subject'   => 'Contact information nicetohave.com.mx [:email]',
        'greeting'  => 'Contact information nicetohave.com.mx'
    ],

    // Admin.Shop

    'admin_buy_success'    => [
        'subject'   => 'Your purchase at nicetohave.com.mx #:BAG_KEY',
        'greeting'  => 'Purchase confirmation',
        'copy'      => '',
        'action'    => 'Purchase details',
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
