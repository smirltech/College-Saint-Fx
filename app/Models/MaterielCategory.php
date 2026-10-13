<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class MaterielCategory extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $with = ['groupe'];

    protected $appends = ['groupe_nom'];

    public function groupe(): BelongsTo
    {
        return $this->belongsTo(self::class, 'materiel_category_id', 'id');
    }

    public function materiels(): HasMany
    {
        return $this->hasMany(Materiel::class);
    }

    public function categories(): HasMany|null
    {
        return $this->hasMany(self::class);
    }

    public function getGroupeNomAttribute(): string|null
    {
        return $this->groupe?->nom;
    }

    public function getMaterielsCountAttribute(): int
    {
        return $this->materiels->count();
    }

    public function getMaterielsCountAggregateAttribute(): int
    {
        return $this->materiels->count() + $this->categories->sum('materielsCountAggregate');
    }
}
