<?php

namespace App\Policies;

use App\Models\CoursEnseignant;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class CoursEnseignantPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, CoursEnseignant $coursEnseignant)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, CoursEnseignant $coursEnseignant)
    {
        //
    }

    public function delete(User $user, CoursEnseignant $coursEnseignant)
    {
        //
    }
}
