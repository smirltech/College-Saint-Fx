<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;

class Option extends Model
{

    public $guarded = [];

    public $fillable = [
        'code',
        'nom',
        'section_id',
    ];

    public function classes(): HasMany
    {
        return $this->hasMany(Classe::class);
    }

    public function getSectionAttribute(): Section
    {
        return Section::where('code',\App\Enums\Section::SECONDAIRE->value)->first();
    }

    // full_name
    public function getFullNameAttribute(): string
    {
        return "{$this->section->fullName} - {$this->nom}";
    }

    // full_name
    public function getFullCodeAttribute(): string
    {
        return "{$this->section->fullCode} {$this->code}";
    }

    // full_name
    public function getShortCodeAttribute(): string
    {
        return substr("{$this->code}", 0, 1);
    }
}
