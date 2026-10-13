<?php

namespace App\Policies;

use App\Models\Classe;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ClassePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user):Response|bool
    {
        return $user->can('classes.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les classes.');
    }

    public function view(User $user, Classe $classe):Response|bool
    {
        return $user->can('classes.view.' . $classe->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette classe.');
    }

    public function create(User $user):Response|bool
    {
        return $user->can('classes.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une classe.');
    }

    public function update(User $user, Classe $classe):Response|bool
    {
        return $user->can('classes.update.' . $classe->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette classe.');
    }

    public function delete(User $user, Classe $classe):Response|bool
    {
        return $user->can('classes.delete.' . $classe->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette classe.');
    }
}
