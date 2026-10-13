<?php

namespace App\Notifications;

use App\Models\Otp;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;


class EmailOtpRequestedNotification extends Notification
{
    use Queueable;


    /**
     * Create a new notification instance.
     *
     * @param Otp $otp
     */
    public function __construct(private readonly Otp $otp)
    {
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
    public function toMail(mixed $notifiable): MailMessage
    {
        return (new MailMessage)
            ->greeting('Bonjour,')
            ->subject('Code de vérification')
            ->line('Voici votre code de vérification.')
            ->line('')
            ->line('# ' . $this->otp->token)
            ->line("Valide jusqu'à " . $this->otp->expired_at->format('H:i'))
            ->line('');
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
