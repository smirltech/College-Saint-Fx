<?php

namespace App\Policies;

use App\Models\EnseignantClasse;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EnseignantClassePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, EnseignantClasse $enseignantClasse)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, EnseignantClasse $enseignantClasse)
    {
        //
    }

    public function delete(User $user, EnseignantClasse $enseignantClasse)
    {
        //
    }
}
