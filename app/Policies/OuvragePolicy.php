<?php

namespace App\Policies;

use App\Models\Ouvrage;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class OuvragePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('ouvrages.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les ouvrages.');
    }

    public function view(User $user, Ouvrage $ouvrage): Response
    {
        return $user->can('ouvrages.view.' . $ouvrage->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cet ouvrage.');
    }

    public function create(User $user): Response
    {
       return  $user->can('ouvrages.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un ouvrage.');
    }

    public function update(User $user, Ouvrage $ouvrage):Response
    {
        return $user->can('ouvrages.update.' . $ouvrage->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cet ouvrage.');
    }

    public function delete(User $user, Ouvrage $ouvrage)
    {
        return $user->can('ouvrages.delete.' . $ouvrage->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cet ouvrage.');
    }

}
