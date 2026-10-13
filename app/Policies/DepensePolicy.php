<?php

namespace App\Policies;

use App\Models\Depense;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DepensePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('depenses.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les dépenses.');
    }

    public function view(User $user, Depense $depense): Response|bool
    {
        return $user->can('depenses.view.' . $depense->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette dépense.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('depenses.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une dépense.');
    }

    public function update(User $user, Depense $depense): Response|bool
    {
        return $user->id === $depense->user_id
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette dépense.');
    }

    public function delete(User $user, Depense $depense): Response|bool
    {
        return $user->can('depenses.delete')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette dépense.');
    }

}
