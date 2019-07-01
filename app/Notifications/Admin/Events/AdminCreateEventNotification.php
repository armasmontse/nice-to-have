<?php

namespace App\Notifications\Admin\Events;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Notifications\Traits\AdminNotificationsTrait;

use App\Setting;

class AdminCreateEventNotification extends Notification
{
    use Queueable;
    use AdminNotificationsTrait;

    public $event;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public function __construct(array $args)
     {
         //
         $this->event = $args['event'];
     }

    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
                    ->from( Setting::getEmail('system'), env('APPNOMBRE') )
                    ->view('vendor.notifications.email')
                    ->subject( trans('notifications.admin_create_event.subject', ['event_key' => $this->event->key]) )
                    ->greeting( Setting::getEmailGreeting() )
                    ->line( trans('notifications.admin_create_event.copy', ['event_key' => $this->event->key]) )
					->action( trans('notifications.admin_create_event.action'), route("admin::events.show", $this->event->id ))
                    ->line( Setting::getEmailFarewell() );
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
