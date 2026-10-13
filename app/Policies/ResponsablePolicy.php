<?php

namespace App\Policies;

use App\Models\Responsable;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ResponsablePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user):Response|bool
    {
        return $user->can('responsables.view.*')
            ? Response::allow()
            : Response::denyAsNotFound('Vous n\'êtes pas autorisé à voir les responsables.');
    }

    public function view(User $user, Responsable $responsable):Response|bool
    {
        return $user->can('responsables.view.' . $responsable->id) || $user->id == $responsable->user_id
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce responsable.');
    }

    public function create(User $user):Response|bool
    {
        return $user->can('responsables.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un responsable.');
    }

    public function update(User $user, Responsable $responsable):Response|bool
    {
        return $user->can('responsables.update.' . $responsable->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce responsable.');
    }

    public function delete(User $user, Responsable $responsable):Response|bool
    {
        return $user->can('responsables.delete.' . $responsable->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce responsable.');
    }
}
