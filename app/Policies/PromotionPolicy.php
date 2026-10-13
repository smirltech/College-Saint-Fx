<?php

namespace App\Policies;

use App\Models\Promotion;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class PromotionPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user)
    {
        //
    }

    public function view(User $user, Promotion $promotion)
    {
        //
    }

    public function create(User $user)
    {
        //
    }

    public function update(User $user, Promotion $promotion)
    {
        //
    }

    public function delete(User $user, Promotion $promotion)
    {
        //
    }

}
