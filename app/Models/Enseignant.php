<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use SmirlTech\LaravelMedia\Traits\HasAvatar;

class Enseignant extends Model
{
    use HasFactory, HasUlids, HasAvatar;

    public $guarded = [];

    // section
    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    // classes

    public function classe(): HasOne
    {
        return $this->hasOne(Classe::class);
    }


    public function classes(): BelongsToMany
    {
        return $this->belongsToMany(Classe::class, 'classe_enseignants');
    }

    // get cours of a classe to array

    public function coursOfClasse($classe_id): array
    {
        $cours = $this->cours($classe_id)->get();
        $cours_array = [];
        foreach ($cours as $cour) {
            $cours_array[$cour->id] = $cour->nom;
        }

        return $cours_array;
    }

    // get name of cours of a classe to array

    public function cours($classe_id = null): BelongsToMany
    {
        $query = $this->belongsToMany(Cours::class, 'cours_enseignants')
            ->where('annee_id', Annee::encours()->id);
        if ($classe_id) {
            $query->where('classe_id', $classe_id);
        }

        return $query;
    }

    public function scopeClasse(Builder $query, Classe $classe): Builder
    {
        // cours where section_id = classe.section_id and not in cours_enseignants where classe_id = classe.id and annee_id = annee encours
        return $query->where('section_id', $classe->section_id);
    }

    // primaire
    public function primaire(): bool
    {
        if ($this->section->id == 1 || $this->section->id == 2) {
            return true;
        }

        return false;
    }
}
