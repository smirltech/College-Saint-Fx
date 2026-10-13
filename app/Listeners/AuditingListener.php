<?php

namespace App\Listeners;

use OwenIt\Auditing\Events\Auditing;

class AuditingListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param Auditing $event
     * @return void
     */
    public function handle(Auditing $event)
    {
        return false;
    }
}
