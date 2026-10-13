<?php

namespace App\Models;

use Illuminate\Support\Str;
use Spatie\Permission\Models\Role as SpatieRole;

class Role extends SpatieRole
{
    // get name attribute
    public function getDisplayNameAttribute()
    {
        return __(Str::title(str_replace('-', ' ', $this->name)));
    }

    // display permissions
    public function getDisplayPermissionsAttribute(): string
    {
        return $this->permissions
            ->map(fn ($permission) => $permission->displayName)
            ->implode(', ');
    }
}
