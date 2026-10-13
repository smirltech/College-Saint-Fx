<?php

namespace App\Policies;

use App\Models\Eleve;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class ElevePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response
    {
        return $user->can('eleves.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les élèves.');
    }

    public function view(User $user, Eleve $eleve): Response
    {
        return $user->can('eleves.view.' . $eleve->id) || $user->id == $eleve->user_id
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cet élève.');
    }

    public function create(User $user): Response
    {
        return $user->can('eleves.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un élève.');
    }

    public function update(User $user, Eleve $eleve): Response
    {
        return $user->can('eleves.update.' . $eleve->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cet élève.');
    }

    public function delete(User $user, Eleve $eleve): Response
    {
        return $user->can('eleves.delete.' . $eleve->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cet élève.');
    }
}
