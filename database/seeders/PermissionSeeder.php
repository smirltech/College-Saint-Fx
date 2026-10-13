<?php

namespace Database\Seeders;

use App\Enums\RolePermission;
use App\Enums\UserRole;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Database\Seeder;

class PermissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     *
     * @return void
     */
    public function run(): void
    {
        foreach (RolePermission::cases() as $permission) {
            Permission::create(['name' => $permission->value]);
        }

        foreach (UserRole::cases() as $userRole) {
            $role = Role::create(['name' => $userRole->value]);
            $role->givePermissionTo($userRole->permissions());
        }
    }
}
