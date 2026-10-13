<?php

namespace App\Models;

use App\Enums\UserRole;
use App\Traits\HasAvatar;
use Closure;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Illuminate\Support\Facades\Hash;
use LaravelIdea\Helper\App\Models\_IH_User_C;
use Spatie\Permission\Traits\HasRoles;

class User extends Authenticatable
{
    use HasFactory, Notifiable, HasRoles, HasAvatar, HasUlids;

    protected $guarded = [];

    /**
     * The attributes that should be cast to native types.
     *
     * @var array
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
    ];

    public static function getStaff(): Collection|array|_IH_User_C
    {
        return self::whereHas('roles', function ($q) {
            $q->where('name', '!=', UserRole::parent->value)
                ->where('name', '!=', UserRole::eleve->value);
        })->orderByDesc('id')->get();
    }

    public function lectures(): HasMany
    {
        return $this->hasMany(Lecture::class);
    }

    // get nom attribute

    public function eleve(): HasOne
    {
        return $this->hasOne(Eleve::class);
    }

    public function getNomAttribute(): string
    {
        return $this->eleve->nom ?? $this->responsable->nom ?? $this->name ?? 'N/A';
    }

    public function responsable(): HasOne
    {
        return $this->hasOne(Responsable::class);
    }

    public function isAdmin(): bool
    {
        return $this->hasRole(UserRole::admin->value);

    }

    public function isParent(): bool
    {
        return $this->hasRole(UserRole::parent->value);
    }

    public function isEleve(): bool
    {
        return $this->hasRole(UserRole::eleve->value);
    }

    public function adminlte_image()
    {
        return $this->avatar;
    }

    public function image()
    {
        return $this->avatar;
    }

    public function adminlte_desc(): string
    {
        return $this->roles->first()->name ?? 'N/A';
    }

    public function adminlte_profile_url(): string
    {
        return route('users.edit', $this);
    }

    public function getRoleNameAttribute(): string
    {
        return $this->role->name ?? 'Non assigné';
    }

    // set password attribute

    public function getRoleAttribute(): Closure|Role|null
    {
        return $this->roles->first();
    }

    public function setPasswordAttribute($value): void
    {
        if ($value) {
            $this->attributes['password'] = Hash::make($value);
        }

    }

    // all permission names attribute

    // display permissions attribute

    public function setRoleIdAttribute($role_id): void
    {
        $this->syncRoles($role_id);
    }

    public function getDisplayPermissionsAttribute(): string
    {
        return $this->getAllPermissions()->pluck('name')->implode(', ');
    }
}
