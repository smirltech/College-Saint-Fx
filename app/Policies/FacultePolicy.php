<?php

namespace App\Policies;

use App\Models\Option;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class FacultePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user)
    {
        //
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Option $faculte
     * @return Response|bool
     */
    public function view(User $user, Option $faculte)
    {
        //
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param Option $faculte
     * @return Response|bool
     */
    public function update(User $user, Option $faculte)
    {
        //
    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Option $faculte
     * @return Response|bool
     */
    public function delete(User $user, Option $faculte)
    {
        //
    }
}
