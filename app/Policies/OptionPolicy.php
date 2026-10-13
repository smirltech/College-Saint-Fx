<?php

namespace App\Policies;

use App\Models\Option;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OptionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user):Response|bool
    {
        return $user->can('options.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les options.');
    }


    public function view(User $user, Option $option):Response|bool
    {
        return $user->can('options.view.' . $option->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette option.');
    }

    public function create(User $user):Response|bool
    {
        return $user->can('options.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une option.');
    }

    public function update(User $user, Option $option):Response|bool
    {
        return $user->can('options.update.' . $option->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette option.');
    }

    public function delete(User $user, Option $option):Response|bool
    {
        return $user->can('options.delete.' . $option->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette option.');
    }
}
