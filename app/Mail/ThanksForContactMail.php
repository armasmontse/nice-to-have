<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\Setting;

class ThanksForContactMail extends Mailable
{
    use Queueable, SerializesModels;

    protected $name;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $name)
    {
        $this->name = $name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from(Setting::getEmail('contact'), env('APPNOMBRE'))
                    ->view('vendor.notifications.email')
                    ->text('vendor.notifications.email-plain')
                    ->subject(trans('notifications.thanks_for_contact.subject'))
                    ->with([
                        'greeting'   => trans('notifications.thanks_for_contact.greeting') . $this->name . ',',
                        'introLines' => [trans('notifications.thanks_for_contact.message')], //, 'Mientras respondemos, puedes visitar nuestra tienda y adquirir el producto que más te guste.'
                        'outroLines' => [],
                        'actionText' => 'Visitar la tienda',
                        'actionUrl'  => route('client::shop.index'),
                        'level'      => 'success'
                    ]);
    }
}
