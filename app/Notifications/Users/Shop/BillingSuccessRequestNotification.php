<?php

namespace App\Notifications\Users\Shop;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Setting;

class BillingSuccessRequestNotification extends Notification
{
    use Queueable;

    protected $personal_bag;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(array $args)
    {
        $this->personal_bag = $args["personal_bag"];
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
                    ->subject( trans('notifications.billing_success_request.subject', ['bag_key' => $this->personal_bag->key]) )
                    ->greeting( Setting::getEmailGreeting() )
                    ->line( Setting::getEmailCopy('billing') )
                    ->action( trans('notifications.billing_success_request.action'), $this->personal_bag->thank_you_page_billing_url )
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
