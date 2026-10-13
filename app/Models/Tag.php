<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Spatie\Tags\Tag as SpatieTag;

class Tag extends SpatieTag
{
    use HasFactory;

    public $guarded = [];

    public function ouvrage_etiquette(): HasMany|null
    {
        return $this->hasMany(OuvrageEtiquette::class);
    }

    // get nom attribute
    public function getNomAttribute(): string
    {
        return $this->name;
    }
}
