<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class OffreNotification extends Mailable
{
    use Queueable, SerializesModels;
    public $data =[];
    public $data2 =[];
    /**
     * Create a new message instance.
     *
     * @return void
     */

    public function __construct(Array $user , Array $offre)
    {
        $this->data  = $user;
        $this->data2 = $offre;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('leconsultant@gmail.com')
        ->subject("Notification d' appel d'offre")
        ->view('component.emails.offreNotification');
    }
}
