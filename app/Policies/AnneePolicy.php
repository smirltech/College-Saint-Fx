<?php

namespace App\Policies;

use App\Models\Annee;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class AnneePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('annees.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les années.');
    }

    public function view(User $user, Annee $annee): Response
    {
        return $user->can('annees.view.' . $annee->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette année.');
    }

    public function create(User $user): Response
    {
       return  $user->can('annees.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une année.');
    }

    public function encours(User $user): Response
    {
        return  $user->can('annees.encours')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à changer année en cours.');
    }

    public function update(User $user, Annee $annee):Response
    {
        return $user->can('annees.update.' . $annee->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette année.');
    }

    public function delete(User $user, Annee $annee)
    {
        return $user->can('annees.delete.' . $annee->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette année.');
    }
}
