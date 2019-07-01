<?php

namespace App\Notifications\Users\Events;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Setting;

class CashOutsSuccessRequestNotification extends Notification
{
    use Queueable;

    protected $perosnal_event;
	protected $cash_out;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $args)
    {
        $this->perosnal_event = $args["personal_event"];
		$this->cash_out = $args["cash_out"];
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
                    ->success()
                    ->view('vendor.notifications.email')
                    ->subject( trans('notifications.cash_outs_success_request.subject', ['event_key' => $this->perosnal_event->key]) )
                    ->greeting( Setting::getEmailGreeting() )
                    ->line( Setting::getEmailCopy('cash_out') )
                    ->action( trans('notifications.cash_outs_success_request.action'), $this->perosnal_event->cash_outs_url )
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
