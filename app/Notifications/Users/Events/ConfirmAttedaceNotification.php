<?php

namespace App\Notifications\Users\Events;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;

use App\Models\Events\Event;
use App\Setting;

class ConfirmAttedaceNotification extends Notification
{
    use Queueable;
	public $event;
    public $assistant;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Event $event, $assistant)
    {
        $this->event = $event;
        $this->assistant = $assistant;
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
                    ->success()
                    ->view('vendor.notifications.email')
                    ->subject(trans_choice('notifications.confirm_attendance.subject', count($this->assistant['names']), ['event_key' => $this->event->key, 'assistants' => $this->implodeAssistants() ]))
                    ->greeting(Setting::getEmailGreeting())
                    ->line(trans_choice('notifications.confirm_attendance.copy', count($this->assistant['names']), ['assistants' => $this->implodeAssistants()]))
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


    public function implodeAssistants(){
        if (count($this->assistant['names']) > 0) {
            if (count($this->assistant['names']) == 1) {
                return head($this->assistant['names']);
            }
            else {
                $implode = '';

                foreach ($this->assistant['names'] as $name) {
                    if ($name == head($this->assistant['names'])) {
                        $implode .= $name;
                    }
                    elseif ($name == last($this->assistant['names'])) {
                        $implode .= ' y '.$name;
                    }
                    else {
                        $implode .= ', '.$name;
                    }

                }

                return $implode;
            }
        }
    }
}
