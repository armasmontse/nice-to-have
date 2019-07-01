<?php

namespace App\Notifications\Admin\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Notifications\Traits\AdminNotificationsTrait;

use App\Setting;

class AdminBuyNotification extends Notification
{
    use Queueable;
	use AdminNotificationsTrait;

    public $active_bag;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct( array $args )
    {
        $this->active_bag = $args["active_bag"];
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
                    ->subject( trans('notifications.admin_buy_success.subject', ['bag_key' => $this->active_bag->key]) )
                    ->greeting( Setting::getEmailGreeting() ) // por generico para todas los admin
                    ->line( Setting::getEmailCopy('purchase') ) // por definir
                    ->action( trans('notifications.admin_buy_success.action'), route("admin::bags.show", $this->active_bag->key )  )
                    ->line( Setting::getEmailFarewell() ); // por generico para todas los admin
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
