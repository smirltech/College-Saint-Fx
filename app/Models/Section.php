<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Section extends Model
{
    use HasFactory;

    public $guarded = [];

    public function getOptionsAttribute(): ?Collection
    {
       if($this->isSecondaire()) {
           return Option::all();
       }
       return  null;
    }

    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    public function inscriptions(): HasManyThrough
    {
        return $this->hasManyThrough(Inscription::class,Classe::class);
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->nom}";
    }

    // full_name
    public function getFullCodeAttribute(): string
    {
        return "{$this->code}";
    }

    // full_name
    public function getShortCodeAttribute(): string
    {
        return substr("{$this->code}", 0, 1);
    }

    public function primaire($strict = false): bool
    {
        if ($strict && $this->id == 2) {
            return true;
        } elseif (! $strict && ($this->id == 1 || $this->id == 2)) {
            return true;
        }

        return false;
    }

    public function maternelle(): bool
    {
        if ($this->id == 1) {
            return true;
        }

        return false;
    }

    public function isSecondaire(): bool
    {
        if ($this->id == 3) {
            return true;
        }

        return false;
    }
}
