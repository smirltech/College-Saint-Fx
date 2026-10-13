<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class PasswordResettedNotification extends Notification
{
    use Queueable;
    private string $password;

    /**
     * Create a new notification instance.
     *
     * @return void
     */
    public function __construct(string $password)
    {
        $this->password = $password;
    }


    /**
     * Get the notification's delivery channels.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function via($notifiable)
    {
        return ['mail'];
    }

    /**
     * Get the mail representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return \Illuminate\Notifications\Messages\MailMessage
     */
    public function toMail($notifiable)
    {
        // password resetted notification

        return (new MailMessage)
            ->subject('Mot de passe réinitialisé')
            ->greeting('Salut ' . $notifiable->name)
            ->line("Votre mot de passe a été réinitialisé avec succès.")
            ->line('Votre mot de passe est : ' . $this->password)
            ->line('Vous pouvez vous connecter à l\'adresse suivante : ' . route('login'))
            ->line('Merci pour votre confiance !');
    }

    /**
     * Get the array representation of the notification.
     *
     * @param  mixed  $notifiable
     * @return array
     */
    public function toArray($notifiable)
    {
        return [
            //
        ];
    }
}
