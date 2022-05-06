<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class RechazoDeSolicitudDeTaller extends Mailable
{
  use Queueable, SerializesModels;
  public $datos_correo;
  public $datos_recibidos;
  public $datos_taller;
  /**
   * Create a new message instance.
   *
   * @return void
   */
  public function __construct($datos_correo, $datos_recibidos, $datos_taller)
 {
     $this->datos_correo = $datos_correo;
     $this->datos_recibidos = $datos_recibidos;
     $this->datos_taller = $datos_taller;
 }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
      return $this->view('mails.mensaje_rechazo');
  }

}
