<?php

namespace App\Policies;

use App\Models\Materiel;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MaterielPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('materiels.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les materiels.');
    }

    public function view(User $user, Materiel $materiel): Response|bool
    {
        return $user->can('materiels.view.' . $materiel->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce materiel.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('materiels.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un materiel.');
    }

    public function update(User $user, Materiel $materiel): Response|bool
    {
        return $user->can('materiels.update.' . $materiel->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce materiel.');
    }

    public function delete(User $user, Materiel $materiel): Response|bool
    {
        return $user->can('materiels.delete.' . $materiel->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce materiel.');
    }
}
