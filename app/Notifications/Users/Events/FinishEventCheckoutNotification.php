<?php

namespace App\Notifications\Users\Events;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Setting;
use App\Models\Shop\Bag;

class FinishEventCheckoutNotification extends Notification
{
    use Queueable;

    public $bag;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Bag $bag)
    {
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
                    ->subject($notifiable->first_name . ', ' . trans('notifications.finish_event_checkout.subject'))
                    ->greeting(Setting::getEmailGreeting())
                    ->line($notifiable->first_name . ', ' . trans('notifications.finish_event_checkout.message'))
                    ->action(trans('notifications.finish_event_checkout.action'), route('client::bag.checkout:get', ['active_bag' => $this->bag->key ]))
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
