<?php

namespace App\Policies;

use App\Models\Devoir;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DevoirPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('devoirs.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les devoirs.');
    }

    public function view(User $user, Devoir $devoir): Response
    {
        return $user->can('devoirs.view.' . $devoir->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir ce devoir.');
    }

    public function create(User $user): Response
    {
       return  $user->can('devoirs.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un devoir.');
    }

    public function update(User $user, Devoir $devoir):Response
    {
        return $user->can('devoirs.update.' . $devoir->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier ce devoir.');
    }

    public function delete(User $user, Devoir $devoir)
    {
        return $user->can('devoirs.delete.' . $devoir->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer ce devoir.');
    }
}
