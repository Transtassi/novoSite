<?php

namespace App\Mail;

use App\Models\Clients;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class SendMail extends Mailable
{
  use Queueable, SerializesModels;

  /**
   * Create a new message instance.
   *
   * @return void
   */

  private $objClients;

  public function __construct($client)
  {
    $this->objClients = $client;
  }

  /**
   * Build the message.
   *
   * @return $this
   */
  public function build()
  {
    // Função para enviar os e-mails para os clientes
    $this->subject('Retorno Trabalhe Conosco - Tassi Transportes');
    $this->to($this->objClients->email, $this->objClients->name);
    return $this->view('mail.sendMail', [
      'client' => $this->objClients
    ]);
  }
}
