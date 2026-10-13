<?php

namespace App\Policies;

use App\Models\Diplome;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class DiplomePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Diplome $diplome)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Diplome $diplome)
    {
        //
    }

    public function delete(User $user, Diplome $diplome)
    {
        //
    }
}
