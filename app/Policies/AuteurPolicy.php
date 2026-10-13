<?php

namespace App\Policies;

use App\Models\Auteur;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AuteurPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('auteurs.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les auteurs.');
    }

    public function view(User $user, Auteur $auteur): Response
    {
        return $user->can('auteurs.view.' . $auteur->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cet auteur.');
    }

    public function create(User $user): Response
    {
       return  $user->can('auteurs.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un auteur.');
    }

    public function update(User $user, Auteur $auteur):Response
    {
        return $user->can('auteurs.update.' . $auteur->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cet auteur.');
    }

    public function delete(User $user, Auteur $auteur)
    {
        return $user->can('auteurs.delete.' . $auteur->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cet auteur.');
    }

}
