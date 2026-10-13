<?php

namespace App\Policies;

use App\Enums\Permission\DemandePermission;
use App\Models\Demande;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class DemandePolicy
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
        return $user->can(DemandePermission::viewAny());
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param Demande $demande
     * @return Response|bool
     */
    public function view(User $user, Demande $demande)
    {
        return $user->can(DemandePermission::view()) and $user->faculte_id === $demande->faculte->id;

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
     * @param Demande $demande
     * @return Response|bool
     */
    public function update(User $user, Demande $demande)
    {
        return $user->can(DemandePermission::update()) and $user->faculte_id === $demande->faculte->id;

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param Demande $demande
     * @return Response|bool
     */
    public function delete(User $user, Demande $demande)
    {
        return $user->can(DemandePermission::delete()) and $user->faculte_id === $demande->faculte->id;

    }
}
