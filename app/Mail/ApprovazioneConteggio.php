<?php

namespace App\Mail;

use App\Conteggio;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;
use Illuminate\Contracts\Queue\ShouldQueue;

class ApprovazioneConteggio extends Mailable
{
    use Queueable, SerializesModels;

    
    public $conteggio;

    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Conteggio $conteggio)
    {
        $this->conteggio = $conteggio;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->markdown('emails.approvazione-conteggio');
    }
}
