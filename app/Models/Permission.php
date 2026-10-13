<?php

namespace App\Models;

use App\Enums\RolePermission;
use Spatie\Permission\Models\Permission as SpatiePermission;

class Permission extends SpatiePermission
{
    public function getDisplayNameAttribute(): ?string
    {
        return RolePermission::tryFrom($this->name)?->label();
    }
}
