<?php

namespace App\Console\Commands;

use App\Enums\RolePermission;
use App\Enums\UserRole;
use App\Models\Permission;
use App\Models\Role;
use Illuminate\Console\Command;

class RefreshPermissions extends Command
{
    protected $signature = 'app:refresh-permissions {remove? : Remove all permissions before refreshing}';

    protected $description = 'Command description';

    public static function refreshPermissions(bool $remove = true): void
    {
        foreach (RolePermission::cases() as $permission) {
            Permission::firstOrCreate(
                ['name' => $permission->value]
            );
        }

        // remove permissions that are not in the enum
        Permission::whereNotIn('name', RolePermission::toArray())->delete();

        foreach (UserRole::cases() as $userRole) {
            $role = Role::firstOrCreate(['name' => $userRole->value]);


            if ($remove) {
                $role->syncPermissions($userRole->permissions());
            } else {
                $role->givePermissionTo($userRole->permissions());
            }

        }
    }

    // params to be passed to the command to be used in the handle method true|false
    public function handle(): void
    {
        if ($this->argument('remove')) {
            self::refreshPermissions(remove: true);
        } else {
            self::refreshPermissions();
        }

    }
}
