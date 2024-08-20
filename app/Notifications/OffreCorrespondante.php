<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class OffreCorrespondante extends Notification
{
    use Queueable;

    public $offre;
    public $user;

    public function __construct($offre, $user)
    {
        $this->offre = $offre;
        $this->user = $user;
    }

    public function via($notifiable)
    {
        return ['mail'];
    }

    public function toMail($notifiable)
    {
        return (new MailMessage)
                    ->subject('Nouvelle Offre Correspondante')
                    ->greeting('Bonjour ' . $this->user->name . ',')
                    ->line('Une nouvelle offre correspond à vos critères.')
                    ->line('Offre : ' . $this->offre->titre)
                    ->action('Voir l\'offre', url('/offres/' . $this->offre->id))
                    ->line('Merci d\'utiliser notre application!');
    }

    public function toArray($notifiable)
    {
        return [
            'offre_id' => $this->offre->id,
        ];
    }
}
