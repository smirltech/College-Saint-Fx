<?php

namespace App\Notifications;

use App\Models\User;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class UserCreatedNotification extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(private ?string $password)
    {

    }

    /**
     * Get the notification's delivery channels.
     *
     * @param mixed $notifiable
     * @return array
     */
    public function via(User $notifiable)
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
            ->subject('Compte ' . $notifiable->role_name)
            ->greeting('Salut ' . $notifiable->name)
            ->line("Votre compte {$notifiable->role_name} viens d'etre créé avec succès.")
            ->lineIf($this->password, 'Votre mot de passe est : ' . $this->password)
            ->line('Vous pouvez vous connecter à l\'adresse suivante : ' . route('login'))
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
