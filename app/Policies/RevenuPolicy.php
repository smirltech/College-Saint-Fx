<?php

namespace App\Policies;

use App\Models\Revenu;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RevenuPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('revenus.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les revenus.');
    }

    public function view(User $user, Revenu $revenu): Response|bool
    {
        return $user->can('revenus.view.' . $revenu->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce revenu.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('revenus.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un revenu.');
    }

    public function update(User $user, Revenu $revenu): Response|bool
    {
        return $user->can('revenus.update.' . $revenu->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce revenu.');
    }

    public function delete(User $user, Revenu $revenu): Response|bool
    {
        return $user->can('revenus.delete.' . $revenu->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce revenu.');
    }
}
