<?php

namespace App\Policies;

use App\Models\ClasseEnseignant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ClasseEnseignantPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, ClasseEnseignant $classeEnseignant)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, ClasseEnseignant $classeEnseignant)
    {
        //
    }

    public function delete(User $user, ClasseEnseignant $classeEnseignant)
    {
        //
    }
}
