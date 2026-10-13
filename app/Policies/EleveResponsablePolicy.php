<?php

namespace App\Policies;

use App\Models\EleveResponsable;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class EleveResponsablePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, EleveResponsable $eleveResponsable)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, EleveResponsable $eleveResponsable)
    {
        //
    }

    public function delete(User $user, EleveResponsable $eleveResponsable)
    {
        //
    }
}
