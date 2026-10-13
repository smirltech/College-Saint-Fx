<?php

namespace App\Policies;

use App\Models\Presence;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PresencePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Presence $presence)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Presence $presence)
    {
        //
    }

    public function delete(User $user, Presence $presence)
    {
        //
    }

}
