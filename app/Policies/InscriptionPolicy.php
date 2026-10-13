<?php

namespace App\Policies;

use App\Models\Inscription;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class InscriptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user):Response|bool
    {
        return $user->can('inscriptions.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les inscriptions.');
    }

    public function view(User $user, Inscription $inscription):Response|bool
    {
        return $user->can('inscriptions.view.'. $inscription->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette inscription.');
    }

    public function create(User $user):Response|bool
    {
        return $user->can('inscriptions.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une inscription.');
    }

    public function update(User $user, Inscription $inscription):Response|bool
    {
        return $user->can('inscriptions.update'. $inscription->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette inscription.');
    }

    public function delete(User $user, Inscription $inscription):Response|bool
    {
        return $user->can('inscriptions.delete'. $inscription->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette inscription.');
    }
}
