<?php

namespace App\Policies;

use App\Models\Tag;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class TagPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        return $user->can('tags.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir les étiquettes.');
    }

    public function view(User $user, Tag $etiquette): Response
    {
        return $user->can('tags.view.' . $etiquette->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cette étiquette.');
    }

    public function create(User $user): Response
    {
        return $user->can('tags.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer une étiquette.');
    }

    public function update(User $user, Tag $etiquette): Response
    {
        return $user->can('tags.update.' . $etiquette->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cette étiquette.');
    }

    public function delete(User $user, Tag $etiquette)
    {
        return $user->can('tags.delete.' . $etiquette->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cette étiquette.');
    }
}
