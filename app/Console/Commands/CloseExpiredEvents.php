<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;

use App\Models\Events\Event;
use App\Models\Events\EventStatus;

use Carbon\Carbon;
use App\Setting;

use Illuminate\Support\Facades\Mail;
use App\Mail\Cltvo\FatalErrorMail;

use App\Notifications\Users\Events\CloseEventNotification;
use App\Notifications\Admin\Events\AdminCloseEventNotification;

class CloseExpiredEvents extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'events:close-expired';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Close all expired events on database';

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        // Obtenemos el setting con la expiración del evento
        $event_expiration = Setting::getEventExpiration();

        // Fecha actual en objecto Carbon
        $date = Carbon::now();

        // Restar a la fecha actual el valor del setting
        $close_day = $date->subMonths($event_expiration);

        // Setear el timezone a UTC
        $close_day->setTimezone('UTC');

        // Obtener el status finalizado para los eventos.
        $finished_status = EventStatus::getFinish();

        // Obtener todos los eventos cuyo status no está finalizado pero que ya pasó su fecha de expiración
        $events = Event::whereDate('date', '<=' , $close_day->toDateString())->whereHas('eventStatus', function ($query) use ($finished_status) { $query->where('id', '<>', $finished_status->id); })->get();

        foreach ($events as $event) {

            $close_event_response = $event->closeEvent();

            if ($close_event_response['type'] == 'error') {

                $code = 'Error al cerrar el evento ' . $event->key . '.';

                Mail::to('hola@elcultivo.mx')->send(new FatalErrorMail($code, $close_event_response['message']));

            }elseif ($close_event_response['type'] == 'success') {

                $event->user->notify(new CloseEventNotification(['event' => $event]));

                AdminCloseEventNotification::AdminNotify(['event' => $event]);

            }

        }

    }
}
