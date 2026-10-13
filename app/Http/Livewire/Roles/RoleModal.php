<?php

namespace App\Http\Livewire\Roles;

use App\Http\Livewire\BaseComponent;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class RoleModal extends BaseComponent
{
    public Role $role;
    public Collection $permissions;
    public string $permission;
    public array $new_permissions = [];

    // rules function
    private bool $action_create = false;

    /**
     * @throws AuthorizationException
     */
    public function mount(Role $role): void
    {
        if ($role->id) {
            $this->authorize('update', $role);
        } else {
            $this->authorize('create', Role::class);
        }

        $this->role = $role;
        $this->permissions = Permission::orderBy('name')->get(['id', 'name'])->sortBy('displayName');
        $this->new_permissions = $role->permissions->pluck('id')->toArray();
    }

    public function render(): View|Factory|Application
    {
        return view('livewire.roles.role-modal')->with('title', $this->role->id ? $this->role->display_name : 'Créer un rôle');
    }

    /**
     */
    public function save(): void
    {

        $bool = $this->role->exists;

        $this->validate();
        $this->role->save();
        if (count($this->new_permissions) > 0) {
            $this->role->syncPermissions($this->new_permissions);
        }
        if ($bool) {
            $this->emit('refreshRoles');
            $this->alert('success', 'Rôle modifié avec succès');
            //$this->flash('success', 'Rôle créé avec succès', [], route('roles.index'));
        } else {
            $this->flash('success', 'Rôle créé avec succès', [], route('roles.index'));
        }
    }


    public function delete(): void
    {
        $this->role->delete();
        $this->flash('success', 'Rôle supprimé avec succès', [], route('roles.index'));
    }

    // delete

    public function getPermissionNames(): array
    {
        // get permission names from $new_permissions array of ids
        $permission_names = [];
        foreach ($this->new_permissions as $permission_id) {
            $permission_names[] = $this->permissions->find($permission_id)->displayName;
        }
        return $permission_names;
    }

    // updated permission_id
    public function updatedPermission(): void
    {

    }


    protected function rules(): array
    {
        return [
            'role.name' => 'required|unique:roles,name,' . $this->role->id,
            'new_permissions' => 'nullable|array',
            'role.description' => 'nullable|string|max:255',
        ];
    }


}
