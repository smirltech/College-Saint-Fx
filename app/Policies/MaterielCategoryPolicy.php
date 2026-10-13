<?php

namespace App\Policies;

use App\Models\MaterielCategory;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class MaterielCategoryPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): Response|bool
    {
        return $user->can('materiel-categories.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les catégories de materiels.');
    }

    public function view(User $user, MaterielCategory $materielCategory): Response|bool
    {
        return $user->can('materiel-categories.view.' . $materielCategory->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette catégorie de materiels.');
    }

    public function create(User $user): Response|bool
    {
        return $user->can('materiel-categories.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une catégorie de materiels.');
    }

    public function update(User $user, MaterielCategory $materielCategory): Response|bool
    {
        return $user->can('materiel-categories.update.' . $materielCategory->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette catégorie de materiels.');
    }

    public function delete(User $user, MaterielCategory $materielCategory): Response|bool
    {
        return $user->can('materiel-categories.delete.' . $materielCategory->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette catégorie de materiels.');
    }
}
