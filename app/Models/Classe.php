<?php

namespace App\Models;

use App\Enums\ClasseNiveau;
use App\Enums\FraisType;
use App\Enums\ResultatType;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Classe extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'niveau' => ClasseNiveau::class,
    ];


    public function inscriptionsAsOfPlaceOfResultats(ResultatType $resultatType)
    {
        $inscriptions_temp = $this->inscriptions->all();
        usort($inscriptions_temp, function ($insc1, $insc2) use ($resultatType) {
            $r1 = $insc1->resultats->where('custom_property', $resultatType)->first();
            $r2 = $insc2->resultats->where('custom_property', $resultatType)->first();

            return $r1?->place > $r2?->place;
        });

        return $inscriptions_temp;
    }

    /*
     * Return a list of inscriptions sorted by place of the results as of type
     */

    public function eleves(): BelongsToMany
    {
        return $this->belongsToMany(Eleve::class, 'inscriptions')->where('annee_id', Annee::encours()->id);
    }


    public function getNomAttribute(): string
    {
        return "{$this->niveau?->label()} - {$this->parent?->nom}";
    }

    public function getFullCodeAttribute(): string
    {
        return "{$this->niveau->value} {$this->parent?->fullCode}";
    }

    // full_name

    public function getShortCodeAttribute(): string
    {
        return "{$this->niveau->value} {$this->parent?->shortCode}";
    }

    // full_name

    public function getParentUrlAttribute(): ?string
    {
        $parent_url = '';
        $parent = $this->parent;
       if ($parent instanceof Option) {
            $parent_url = route('scolarite.options.show', $parent->id);
        } elseif ($parent instanceof Section) {
            $parent_url = route('scolarite.sections.show', $parent->id);
        }

        return $parent_url;
    }

    public function getParentAttribute(): Option|Section|null
    {
       return  $this->option??$this->section;
    }

    public function enseignants(): BelongsToMany
    {
        return $this->belongsToMany(Enseignant::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id);
    }

    public function cours(): BelongsToMany
    {
        return $this->belongsToMany(Cours::class, 'cours_enseignants')->where('annee_id', Annee::encours()->id)->withPivot('classe_id');
    }

    // cours

    public function coursEnseignants(): HasMany
    {
        return $this->hasMany(CoursEnseignant::class)->where('annee_id', Annee::encours()->id);
    }


    public function section(): BelongsTo
    {
        return $this->belongsTo(Section::class);
    }

    public function option(): BelongsTo
    {
        return $this->belongsTo(Option::class);
    }


    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    // get enseignant from enseignant_id attribute

    public function primaire($strict = false): bool
    {
        return $this->section->primaire(strict: $strict);
    }

    // function primaire

    public function maternelle(): bool
    {
        return $this->section->maternelle();
    }

    public function secondaire(): bool
    {
        return $this->section->secondaire();
    }

    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class)->with('inscription')->ofToday();
    }

   /* public function nonInscriptions($date): Collection|array
    {
        $df = $this->inscriptions()->whereDoesntHave('presences', function ($q) use ($date) {
            $q->where('date', $date);
        })->get();
        //  dd($df);
        return $df;
    }*/

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class)->where('annee_id', Annee::encours()->id);
    }

    // get frais inscription attribute
    public function getFraisInscriptionAttribute(): ?Frais
    {
        $annee_id = Annee::id();

        $frais = Frais::where('annee_id', $annee_id)
            ->where('type', FraisType::INSCRIPTION)
            ->where('classable_type', 'like', '%Classe')
            ->where('classable_id', $this->id)
            ->first();
        if ($frais != null) {
            return $frais;
        }

        if ($this->filiere_id) {
            $frais = Frais::where('annee_id', $annee_id)
                ->where('type', FraisType::INSCRIPTION)
                ->where('classable_type', 'like', '%Option')
                ->where('classable_id', $this->filiere_id)
                ->orderBy('nom')
                ->first();
            if ($frais != null) {
                return $frais;
            }
        }

        if ($this->option_id) {
            $frais = Frais::where('annee_id', $annee_id)
                ->where('type', FraisType::INSCRIPTION)
                ->where('classable_type', 'like', '%Option')
                ->where('classable_id', $this->option_id)
                ->first();
            if ($frais != null) {
                return $frais;
            }
        }
        if ($this->section_id) {
            $frais = Frais::where('annee_id', $annee_id)
                ->where('type', FraisType::INSCRIPTION)
                ->where('classable_type', 'like', '%Section')
                ->where('classable_id', $this->section_id)
                ->first();
            if ($frais != null) {
                return $frais;
            }
        }

        return null;
    }
}
