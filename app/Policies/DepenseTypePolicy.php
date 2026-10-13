<?php

namespace App\Policies;

use App\Models\DepenseType;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DepenseTypePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user):Response|bool
    {
        return $user->can('depense-types.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les types de dépenses.');
    }

    public function view(User $user, DepenseType $depenseType):Response|bool
    {
        return $user->can('depense-types.view.' . $depenseType->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce type de dépenses.');
    }

    public function create(User $user):Response|bool
    {
        return $user->can('depense-types.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un type de dépenses.');
    }

    public function update(User $user, DepenseType $depenseType):Response|bool
    {
        return $user->can('depense-types.update.' . $depenseType->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce type de dépenses.');
    }

    public function delete(User $user, DepenseType $depenseType):Response|bool
    {
        return $user->can('depense-types.delete.' . $depenseType->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce type de dépenses.');
    }
}
