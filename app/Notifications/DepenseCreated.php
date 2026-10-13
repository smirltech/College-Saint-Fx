<?php

namespace App\Notifications;

use App\Models\Depense;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Messages\MailMessage;
use Illuminate\Notifications\Notification;

class DepenseCreated extends Notification
{
    use Queueable;

    /**
     * Create a new notification instance.
     */
    public function __construct(private readonly Depense $depense)
    {
        //
    }

    /**
     * Get the notification's delivery channels.
     *
     * @return array<int, string>
     */
    public function via(object $notifiable): array
    {
        return ['database'];
    }

    /**
     * Get the mail representation of the notification.
     */
    public function toMail(object $notifiable): MailMessage
    {
        return (new MailMessage)
            ->line('The introduction to the notification.')
            ->action('Notification Action', url('/'))
            ->line('Thank you for using our application!');
    }

    /**
     * Get the array representation of the notification.
     *
     * @return array<string, mixed>
     */
    public function toArray(object $notifiable): array
    {
        $status = $this->depense->statuses()->latest()->first();

        return [
            'title' => 'Depense',
            'message' => 'Depense ' . ($status->reason ?? $status->label),
            'link' => route('finance.depenses.show', $this->depense),
        ];
    }
}
