<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AvvisoPagamento extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tipo_mail, $file_pdf)
    {
         $this->tipo_mail = $tipo_mail;
         $this->file_pdf = $file_pdf;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        if ($tipo_mail == 'scaduto' || true) 
          {
          return $this->markdown('emails.avviso-apgamento')->attachFromStorageDisk('fatture', $file_pdf);
          } 
        else 
          {
            
          }
    }
}
