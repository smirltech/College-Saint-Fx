<?php

namespace App\Models;

use App\Enums\AdmissionType;
use App\Enums\DevoirStatus;
use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Enums\Sexe;
use App\Traits\HasScopeAnnee;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Support\Collection;
use OwenIt\Auditing\Auditable;
use Str;

//use Illuminate\Database\Eloquent\SoftDeletes;

class Inscription extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasUlids, Auditable, HasScopeAnnee;

    public $guarded = [];

    protected $casts = [
        'type' => AdmissionType::class,
        'status' => InscriptionStatus::class,
        'categorie' => InscriptionCategorie::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function getCurrentInscriptions(): Collection
    {
        return self::where('annee_id', Annee::id())->get();
    }


    // scope sexe

    public function getLabelAttribute(): string
    {
        return "{$this->eleve->fullName} - {$this->matricule}";
    }

    public function scopeSexe($query, Sexe|string $sexe = Sexe::M)
    {
        if ($sexe) {
            return $query->whereHas('eleve', function ($query) use ($sexe) {
                $query->where('sexe', $sexe);
            });
        }

        return $query;
    }

    public function eleve(): BelongsTo
    {
        return $this->belongsTo(Eleve::class);
    }

    public function getSectionAttribute(): ?Section
    {
        return $this->classe?->section;
    }

    public function getOptionAttribute(): ?Option
    {
        return $this->classe?->option;
    }


    public function getNomCompletAttribute(): string|null
    {
        return $this->getFullNameAttribute();
    }

    public function getFullNameAttribute(): string|null
    {
        return $this->eleve?->fullName;
    }

    public function getMatriculeAttribute(): string|null
    {
        return $this->eleve?->matricule;
    }

    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public function resultats(): HasMany
    {
        return $this->hasMany(Resultat::class);
    }

    public function presence(?string $date = null)
    {
        $date = $date ?? date('Y-m-d');

        return $this->presences()->where('date', $date)->first();
    }

    public function presences(): HasMany
    {
        return $this->hasMany(Presence::class);
    }

    public function annee(): BelongsTo
    {
        return $this->belongsTo(Annee::class);
    }

    public function media(): MorphMany
    {
        return $this->morphMany(Media::class, 'mediable');
    }

    // scope annee

    public function scopeStatus($query, $status = null)
    {
        if ($status) {
            return $query->where('status', $status);
        }

        return $query->where('status', InscriptionStatus::approved);
    }

    // scope eleve

    public function scopeEleve($query, $eleve_id = null)
    {
        if ($eleve_id) {
            return $query->where('eleve_id', $eleve_id);
        }

        return $query;
    }

    // scope classe

    public function scopeClasse($query, $classe_id = null)
    {
        if ($classe_id) {
            return $query->where('classe_id', $classe_id);
        }

        return $query;
    }

    public function getCodeAttribute(): string|null
    {
        return $this?->eleve?->matricule;
    }

    public function getClasseCodeAttribute(): Classe
    {
        return $this->classe;
    }

    public function getMontantAttribute(): int|null
    {
        /* $perc = $this->perceptions()
             ->whereHas('frais', function ($q) {
                 $q->where('type', FraisType::inscription);
             })
             ->first()?->paid;
         // dd((int)($perc));
         return (int)($perc);*/

        return null;
    }

    // SOMMES

    public function perceptions(): HasMany
    {
        return $this->hasMany(Perception::class)->with('frais');
    }

    public function getPerceptionsDuesAttribute(): int
    {
        return $this->perceptions->sum('montant');
    }

    public function getPerceptionsPaidAttribute(): int
    {
        return $this->perceptions->sum('paid');
    }

    public function getPerceptionsBalanceAttribute(): int
    {
        return $this->perceptionsDues - $this->perceptionsPaid;
    }

    // SOMMES
    public function getPerceptionsEncoursAttribute()
    {
        return $this->perceptions->where('balance', '>', 0);
    }

    public function getPerceptionsEncoursCountAttribute()
    {
        return $this->perceptionsEncours->count();
    }

    /** Devoirs */
    public function getDevoirsAttribute(): ?Collection
    {
        return Devoir::where('classe_id', $this->classe_id)->where('status', '!=', DevoirStatus::draft)->get();
    }
}
