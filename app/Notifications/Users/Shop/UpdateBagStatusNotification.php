<?php

namespace App\Notifications\Users\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Setting;

class UpdateBagStatusNotification extends Notification
{
    use Queueable;

    public $bag;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
     public function __construct($bag)
     {
         //
         $this->bag = $bag;
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
                    ->from(Setting::getEmail('system'), env('APPNOMBRE'))
                    ->view('vendor.notifications.email')
                    ->subject(trans('notifications.update_bag_status.subject', ['bag_key' => $this->bag->key]))
                    ->greeting(Setting::getEmailGreeting())
                    ->line(trans('notifications.update_bag_status.copy', ['bag_key' => $this->bag->key, 'bag_status' => strtoupper($this->bag->bagStatus->label), 'status_info' => $this->bag->status_info]))
                    ->action(trans('notifications.update_bag_status.action'), $this->bag->thank_you_page_url)
                    ->line(Setting::getEmailFarewell());
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
