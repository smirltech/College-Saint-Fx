<?php

namespace App\Policies;

use App\Models\Cours;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class CoursPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user):Response|bool
    {
        return $user->can('cours.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les cours.');
    }

    public function view(User $user, Cours $cours):Response|bool
    {
        return $user->can('cours.view.' . $cours->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce cours.');
    }

    public function create(User $user):Response|bool
    {
        return $user->can('cours.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un cours.');
    }

    public function update(User $user, Cours $cours):Response|bool
    {
        return $user->can('cours.update.' . $cours->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce cours.');
    }

    public function delete(User $user, Cours $cours):Response|bool
    {
        return $user->can('cours.delete.' . $cours->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce cours.');
    }
}
