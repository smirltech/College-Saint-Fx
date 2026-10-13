<?php

namespace App\Policies;

use App\Models\Consommable;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ConsommablePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('consommables.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les consommables.');
    }

    public function view(User $user, Consommable $consommable): Response|bool
    {
        return $user->can('consommables.view.' . $consommable->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce consommable.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('consommables.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un consommable.');
    }

    public function update(User $user, Consommable $consommable): Response|bool
    {
        return $user->can('consommables.update.' . $consommable->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce consommable.');
    }

    public function delete(User $user, Consommable $consommable): Response|bool
    {
        return $user->can('consommables.delete.' . $consommable->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce consommable.');
    }
}
