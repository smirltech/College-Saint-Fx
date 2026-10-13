<?php

namespace App\Policies;

use App\Models\Unit;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UnitPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('units.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les unités.');
    }

    public function view(User $user, Unit $unit): Response|bool
    {
        return $user->can('units.view.' . $unit->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette unité.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('units.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une unité.');
    }

    public function update(User $user, Unit $unit): Response|bool
    {
        return $user->can('units.update.' . $unit->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette unité.');
    }

    public function delete(User $user, Unit $unit): Response|bool
    {
        return $user->can('units.delete.' . $unit->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette unité.');
    }

}
