<?php

namespace App\Policies;

use App\Models\Categorie;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CategoriePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Categorie $categorie)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Categorie $categorie)
    {
        //
    }

    public function delete(User $user, Categorie $categorie)
    {
        //
    }
}
