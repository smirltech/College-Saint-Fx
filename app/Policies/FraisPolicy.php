<?php

namespace App\Policies;

use App\Models\Frais;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FraisPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('frais.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les frais.');
    }

    public function view(User $user, Frais $frais): Response|bool
    {
        return $user->can('frais.view.' . $frais->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce frais.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('frais.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un frais.');
    }

    public function update(User $user, Frais $frais): Response|bool
    {
        return $user->can('frais.update.' . $frais->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce frais.');
    }

    public function delete(User $user, Frais $frais): Response|bool
    {
        return $user->can('frais.delete.' . $frais->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce frais.');
    }
}
