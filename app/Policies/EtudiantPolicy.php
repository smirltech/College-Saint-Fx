<?php

namespace App\Policies;

use App\Models\Etudiant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EtudiantPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Etudiant $etudiant)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Etudiant $etudiant)
    {
        //
    }

    public function delete(User $user, Etudiant $etudiant)
    {
        //
    }
}
