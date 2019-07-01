<?php

namespace App\Notifications\Users\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Setting;
use App\Models\Shop\Bag;

class PresentNotification extends Notification
{
    use Queueable;

    public $active_bag;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Bag $active_bag)
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
        $full_name = explode(' ', trim($notifiable->name));

        $name = !empty($full_name[0]) ? $full_name[0] : '';

        return (new MailMessage)
                    ->from(Setting::getEmail('system'), env('APPNOMBRE'))
                    ->success()
                    ->view('vendor.notifications.email')
                    ->subject(trans('notifications.PresentNotification.subject', ['name' => $name]))
                    ->greeting(trans('notifications.PresentNotification.greeting', ['name' => $notifiable->name]))
                    ->line(trans('notifications.PresentNotification.copy', ['user_name' => $this->active_bag->bagUser->user->full_name]))
                    ->action(trans('notifications.PresentNotification.action'), $this->active_bag->getPresentUrl())
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
