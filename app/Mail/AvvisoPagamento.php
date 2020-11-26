<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Str;

class AvvisoPagamento extends Mailable
{
    use Queueable, SerializesModels;


     public $tipo_mail;
     public $file_pdf;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct($tipo_mail, $tipo_pagamento, $file_pdf)
    {
         $this->tipo_mail = $tipo_mail;
         $this->file_pdf = $file_pdf;
         $this->tipo_pagamento = $tipo_pagamento;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {   
        if (true) 
          {
          return $this->markdown('emails.avviso-pagamento-'.Str::slug($this->tipo_mail, '-'))
                      ->subject('Avviso di pagamento mediante '.$this->tipo_pagamento. ' '.$this->tipo_mail.'  da Info Alberghi srl')
                      ->attachFromStorageDisk('fatture', $this->file_pdf);
          } 
        else 
          {
            
          }
    }
}
