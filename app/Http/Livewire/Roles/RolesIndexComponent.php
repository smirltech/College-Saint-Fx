<?php

namespace App\Http\Livewire\Roles;

use App\Console\Commands\RefreshPermissions;
use App\Enums\RolePermission;
use App\Enums\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class RolesIndexComponent extends BaseComponent
{

    public Collection $roles;
    public $title = 'Rôles et permissions';

    protected $listeners = ['refreshRoles' => '$refresh'];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {

        $this->authorize('viewAny', Role::class);
        $this->roles = Role::all();
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.roles.index-component')/*->with([
            'title' => 'Rôles',
        ])*/ ->layoutData(['title' => $this->title, "contentHeaderIcon" => "fas fa-fw fa-wand-magic-sparkles"]);
    }

    public function refreshPermissions(): void
    {


       RefreshPermissions::refreshPermissions();

    }
}
