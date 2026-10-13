<?php

namespace App\Http\Livewire\Notification;

use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Notifications\DatabaseNotification;
use Livewire\Component;
use Livewire\Redirector;

class NoficationIndexComponent extends Component
{
    public mixed $notifications;

    public function mount(): void
    {
        $this->notifications = auth()->user()->notifications;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.notification.nofication-index-component');
    }

    // deleteNotification
    public function deleteNotification(DatabaseNotification $notification): void
    {
        $notification->delete();
        $this->notifications = auth()->user()->notifications;
    }

    public function openNotification(DatabaseNotification $notification): RedirectResponse|Redirector
    {
        $notification->markAsRead();
        return redirect()->to($notification->data['link'] ?? '/');
    }
}
