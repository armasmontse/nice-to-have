<?php

namespace App\Mail\Cltvo;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class FatalErrorMail extends Mailable implements ShouldQueue
{
    use Queueable, SerializesModels;

    protected $errors;
    protected $code;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(string $code, array $errors)
    {
        $this->errors   = $errors;
        $this->code     = $code;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        $introLines = [ 'Parece que hubo '.strtolower($this->code).' , aqui están los detalles: ', ''];

        $introLines = array_merge($introLines, $this->errors);

        return $this->from('hola@elcultivo.mx', env('APPNOMBRE'))
                    ->view('vendor.notifications.email')
                    ->text('vendor.notifications.email-plain')
                    ->subject('Fatal error mail: nicetohave.com.mx ['.$this->code.']')
                    ->with([
                        'greeting'   => 'Hola El Cultivo,',
                        'introLines' => $introLines,
                        'outroLines' => [],
                        'actionText' => 'Ir a nicetohave.com.mx',
                        'actionUrl'  => route('admin::index'),
                        'level'      => 'error',
                    ]);
    }
}
