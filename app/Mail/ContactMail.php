<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ContactMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    /**
    * The input instance.
    *
    * @var input
    */
    protected $input;
    protected $email;
    protected $full_name;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(array $input, string $email, string $full_name)
    {
        $this->input     = $input;
        $this->email     = $email;
        $this->full_name = $full_name;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from($this->email, $this->full_name)
                    ->view('vendor.notifications.email')
                    ->text('vendor.notifications.email-plain')
                    ->subject(trans('notifications.contact_mail.subject', ['email' => $this->email]))
                    ->with([
                        'greeting'   => trans('notifications.contact_mail.greeting'),
                        'introLines' => $this->input,
                        'outroLines' => []
                    ]);
    }
}
