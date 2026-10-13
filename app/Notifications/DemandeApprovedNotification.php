<?php

namespace App\Notifications;

use App\Models\Demande;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DemandeApprovedNotification extends Notification
{
    use Queueable;

    private Demande $demande;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(Demande $demande)
    {
        $this->demande = $demande;
    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param mixed $notifiable
     * @return MailMessage
     */
    public function toMail($notifiable)
    {

        return (new MailMessage)
            ->subject($this->demande->status->message())
            ->greeting('Felicitations!')
            ->line($this->demande->status->message())
            ->lineIf($this->demande->isAccepted(), 'Téléchargez ici : ')
            ->linesIf($this->demande->isAccepted(), $this->demande->generateReleveLinks())
            ->lineIf($this->demande->isRejected(), 'Raison : ' . $this->demande->note)
            ->lineIf($this->demande->isRejected() and $this->demande->reject_reason->isBordereau(), 'Soummettre les bordereaux ici : ' . $this->demande->bordereau_link)
            ->line('Merci pour votre confiance !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
