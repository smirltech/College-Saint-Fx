<?php

namespace App\Policies;

use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class UserPolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view any models.
     *
     * @param User $user
     * @return Response|bool
     */
    public function viewAny(User $user): Response|bool
    {
        return $user->can('users.view.*')
            ? Response::allow()
            : Response::denyAsNotFound('Vous n\'êtes pas autorisé à voir les utilisateurs.');
    }

    /**
     * Determine whether the user can view the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function view(User $user, User $model): Response|bool
    {
        return $user->can('users.view.' . $model->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à voir cet utilisateur.');
    }

    /**
     * Determine whether the user can create models.
     *
     * @param User $user
     * @return bool
     */
    public function create(User $user): Response|bool
    {
        return $user->can('users.create')
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à créer un utilisateur.');

    }

    /**
     * Determine whether the user can update the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function update(User $user, User $model)
    {
        return $user->can('users.update.' . $model->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à modifier cet utilisateur.');

    }

    /**
     * Determine whether the user can delete the model.
     *
     * @param User $user
     * @param User $model
     * @return Response|bool
     */
    public function delete(User $user, User $model): Response|bool
    {
        return $user->can('users.delete.' . $model->id)
            ? Response::allow()
            : Response::deny('Vous n\'êtes pas autorisé à supprimer cet utilisateur.');

    }
}
