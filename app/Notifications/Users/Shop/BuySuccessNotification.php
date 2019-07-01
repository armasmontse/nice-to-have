<?php

namespace App\Notifications\Users\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Setting;

class BuySuccessNotification extends Notification
{
    use Queueable;

    public $active_bag;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct($active_bag)
    {
        //
        $this->active_bag = $active_bag;
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
                    ->subject( trans('notifications.buy_success.subject', ['bag_key' => $this->active_bag->key]) )
                    ->greeting( Setting::getEmailGreeting() )
                    ->line( Setting::getEmailCopy('purchase') )
                    ->action( trans('notifications.buy_success.action'), $this->active_bag->thank_you_page_url )
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
