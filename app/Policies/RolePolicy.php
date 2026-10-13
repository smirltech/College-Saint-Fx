<?php

namespace App\Policies;

use App\Models\Role;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;
use Illuminate\Auth\Access\Response;

class RolePolicy
{
    use HandlesAuthorization;


    public function viewAny(User $user): Response
    {
        return $user->can('roles.view.*')
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à voir les roles.');
    }

    public function view(User $user, Role $role): void
    {
        //
    }

    public function create(User $user): Response
    {
        return $user->can('roles.create')
            ? Response::allow()
            : Response::deny('Vous n\'etes pas autorisé à créer un role.');
    }

    public function update(User $user, Role $role): Response
    {
        if(app()->isLocal()){
            return $user->can('roles.update.' . $role->id)
                ? Response::allow()
                : Response::deny('Vous n\'etes pas autorisé à modifier ce role.');
        }else{
               if ($role->id !== 1)
                 return $user->can('roles.update.' . $role->id)
                     ? Response::allow()
                     : Response::deny('Vous n\'etes pas autorisé à modifier ce role.');
             else
                 return Response::deny('Ce role ne peut pas être modifié.');
        }
    }

    public function delete(User $user, Role $role)
    {
        //
    }

}
