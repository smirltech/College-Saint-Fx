<?php

namespace App\Listeners;

use App\Enums\DepenseStatus;
use App\Models\Depense;
use App\Notifications\DepenseCreated;
use Spatie\ModelStatus\Events\StatusUpdated;

class StatusUpdatedListener
{
    /**
     * Create the event listener.
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     */
    public function handle(StatusUpdated $event): void
    {
        $model = $event->model;

        $status_roles = $model->status_roles;
        if (empty($status_roles)) {
            $status_roles = DepenseStatus::pending->roles();
        }

        if ($model instanceof Depense) {
            $model->notifyAll(new DepenseCreated($model), $status_roles);
        }
    }
}
