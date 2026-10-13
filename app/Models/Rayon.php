<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Rayon extends Model
{
    use HasFactory;

    public $guarded = [];

    public function ouvrages(): HasMany|null
    {
        return $this->hasMany(Ouvrage::class)->orderBy('titre');
    }

    public function groupe(): BelongsTo
    {
        return $this->belongsTo(self::class, 'rayon_id');
    }

    public function categories(): HasMany
    {
        return $this->hasMany(self::class);
    }

    public function getGroupeNomAttribute()
    {
        return $this->groupe?->nom;
    }

    public function getOuvragesCountAttribute(): int
    {
        return $this->ouvrages?->count();
    }

    public function getOuvragesCountAggregateAttribute(): int
    {
        return $this->ouvragesCount + $this->categories->sum('ouvragesCountAggregate');
    }
}
