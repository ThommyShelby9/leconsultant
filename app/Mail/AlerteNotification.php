<?php

namespace App\Mail;

use App\Models\Alerte;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Mail\Mailable;
use Illuminate\Queue\SerializesModels;

class AlerteNotification extends Mailable
{
    use Queueable, SerializesModels;

    public $alerte;

    public function __construct(Alerte $alerte)
    {
        $this->alerte = $alerte;
    }

    public function build()
    {
        return $this->view('emails.alerte_notification')
                    ->subject('Votre Alerte Personnalisée')
                    ->with([
                        'type_marches' => json_decode($this->alerte->marches),
                        'categories_ac' => json_decode($this->alerte->ac),
                    ]);
    }
}