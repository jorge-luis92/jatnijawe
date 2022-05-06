<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;
use App\SolicitudTaller;

class TalleresNotificacion extends Mailable
{
    use Queueable, SerializesModels;

    public $datos_correo;
    public $datos_recibidos;
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($datos_correo, $datos_recibidos)
   {
       $this->datos_correo = $datos_correo;
       $this->datos_recibidos = $datos_recibidos;
   }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('mails.mensaje_correccion');
    }

}
