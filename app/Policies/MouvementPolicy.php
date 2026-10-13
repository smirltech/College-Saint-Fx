<?php

namespace App\Policies;

use App\Models\Mouvement;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MouvementPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('mouvements.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les mouvements.');
    }

    public function view(User $user, Mouvement $mouvement): Response|bool
    {
        return $user->can('mouvements.view.' . $mouvement->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce mouvement.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('mouvements.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un mouvement.');
    }

    public function update(User $user, Mouvement $mouvement): Response|bool
    {
        return $user->can('mouvements.update.' . $mouvement->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce mouvement.');
    }

    public function delete(User $user, Mouvement $mouvement): Response|bool
    {
        return $user->can('mouvements.delete.' . $mouvement->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce mouvement.');
    }
}
