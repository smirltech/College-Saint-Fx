<?php

namespace App\Policies;

use App\Models\ResponsableEleve;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ResponsableElevePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, ResponsableEleve $responsableEleve)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, ResponsableEleve $responsableEleve)
    {
        //
    }

    public function delete(User $user, ResponsableEleve $responsableEleve)
    {
        //
    }
}
