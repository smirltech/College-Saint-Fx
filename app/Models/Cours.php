<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Cours extends Model
{
    use HasFactory;

    public $guarded = [];

    // section
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    // scope classe
    public function scopeClasse(Builder $query, Classe $classe): Builder
    {
        // cours where section_id = classe.section_id and not in cours_enseignants where classe_id = classe.id and annee_id = annee encours
        return $query->where('section_id', $classe->section_id)
            ->whereDoesntHave('coursEnseignants', function (Builder $query) use ($classe) {
                $query->where('classe_id', $classe->id)
                    ->where('annee_id', Annee::encours()->id);
            });
    }

    public function coursEnseignants(): HasMany
    {
        return $this->hasMany(CoursEnseignant::class);
    }

    public function getEnseignantAttribute(): Enseignant
    {
        return $this->coursEnseignants->first()->enseignant;
    }
}
