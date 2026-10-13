<?php

namespace App\Policies;

use App\Models\Enseignant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class EnseignantPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->can('enseignants.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les enseignants.');
    }

    public function view(User $user, Enseignant $enseignant): Response
    {
        return $user->can('enseignants.view.' . $enseignant->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cet enseignant.');
    }

    public function create(User $user): Response
    {
        return $user->can('enseignants.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un enseignant.');
    }

    public function update(User $user, Enseignant $enseignant): Response
    {
        return $user->can('enseignants.update' . $enseignant->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cet enseignant.');
    }

    public function delete(User $user, Enseignant $enseignant): Response
    {
        return $user->can('enseignants.delete' . $enseignant->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cet enseignant.');
    }
}
