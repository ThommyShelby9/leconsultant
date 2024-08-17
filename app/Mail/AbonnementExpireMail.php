<?php

namespace App\Mail;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AbonnementExpireMail extends Mailable
{
    use Queueable, SerializesModels;
    public $data =[];
    /**
     * Create a new message instance.
     *
     * @return void
     */
    public function __construct(Array $user)
    {
        $this->data  = $user;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->from('leconsultant@gmail.com')
        ->subject("Abonnement expire")
        ->view('component.emails.abonnementExpire');
    }
}
