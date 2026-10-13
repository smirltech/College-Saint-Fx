<?php

namespace App\Models;

use App\Enums\Sexe;
use App\Helpers\Helpers;
use App\Traits\HasAvatar;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Str;
use JetBrains\PhpStorm\Pure;
use OwenIt\Auditing\Auditable;

class Eleve extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, Auditable, HasAvatar, HasUlids;

    public $guarded = [];

    protected $casts = [
        'sexe' => Sexe::class,
        'pere' => 'array',
        'mere' => 'array',
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public static function nonInscritsAnneeEnCours(): Collection|array
    {
        return self::whereDoesntHave('inscriptions', function ($q) {
            $q->where('annee_id', Annee::id());
        })->get();
    }

    protected static function booted(): void
    {
        static::saving(function (self $model) {
            if (!$model->matricule) {
                $model->matricule = self::generateUniqueId($model->section_id);
            }
            unset($model->section_id);
        });
    }

    /** generate matricule
     * // {annee}{section_id}{count on section+1}
     * //ex: 2022010001
     * */
    public static function generateUniqueId(string $section_id): string
    {
        $start_year = date('Y');

        $first_part = $start_year . Helpers::pad($section_id);

        $count = self::withoutGlobalScopes()->where('matricule', 'like', $first_part . '%')->count() + 1;

        $second_part = Str::padLeft($count, 4, '0');

        return self::checkMatricule("{$first_part}{$second_part}");
    }


    public static function checkMatricule(string $matricule): string
    {
        $count = self::withoutGlobalScopes()->where('matricule', $matricule)->count();

        if ($count > 0) {
            return self::checkMatricule(((int)$matricule) + 1);
        }

        return $matricule;
    }

    // route model binding

    public function getIncrementing(): bool
    {
        return false;
    }

    public function getKeyType(): string
    {
        return $this->keyType;
    }

    public function user(): BelongsTo|null
    {
        return $this->belongsTo(User::class);
    }

    public function getPresencesAttribute(): Collection
    {
        return $this->inscription?->presences ?? new Collection();
    }

    public function getPresenceColorsAttribute(): array
    {
        $aa = [];
        foreach ($this->inscription->presences as $p) {
            $aa[] = $p->getColor();
        }

        return $aa;
    }

    public function getCodeAttribute(): string
    {
        return $this->id;
    }

    public function getInscriptionAttribute(): ?Inscription
    {
        $i = $this->inscriptions()->where('annee_id', Annee::id())->first();
        if (!$i) {
            return $this->inscriptions()->latest()->first();
        }

        return $i;
    }

    public function inscriptions(): HasMany
    {
        return $this->hasMany(Inscription::class);
    }

    public function getClasseAttribute(): ?Classe
    {
        return $this->inscription->classe ?? null;
    }


    public function resultats(): HasManyThrough
    {
        return $this->hasManyThrough(Resultat::class, Inscription::class)->orderBy('custom_property');
    }

    public function resultatsThisYear()
    {
        return $this->resultats->where('annee_id', Annee::id());
    }

    public function resultatsOfYear($annee_id)
    {
        return $this->resultats->where('annee_id', $annee_id);
    }

    // full_name

    public function currentInscription(): Inscription|null
    {
        return $this->inscription;
    }

    #[Pure]
    public function getNomCompletAttribute(): string
    {
        return $this->getFullNameAttribute();
    }

    public function getFullNameAttribute(): string
    {
        return "{$this->nom}";
    }

    public function responsable_eleve(): HasOne
    {
        return $this->hasOne(ResponsableEleve::class);
    }

    // get profile url

    public function responsables(): HasManyThrough
    {
        return $this->hasManyThrough(Responsable::class, ResponsableEleve::class, 'eleve_id', 'id', 'id', 'responsable_id');
    }

    public function perceptions(): HasManyThrough
    {
        return $this->hasManyThrough(Perception::class, Inscription::class);
    }

    public function getSectionAttribute(): ?Section
    {
        return $this->classe->section ?? null;
    }

    // MONTANTS
    public function getPerceptionsDuesAttribute(): int
    {
        return $this->inscriptions->sum('perceptionsDues');
    }

    public function getPerceptionsPaidAttribute(): int
    {
        return $this->inscriptions->sum('perceptionsPaid');
    }

    public function getPerceptionsBalanceAttribute(): int
    {
        return $this->inscriptions->sum('perceptionsBalance');
    }

    /** Devoirs for this eleve on this year and a specific class
     */
    public function getDevoirsAttribute(): Collection
    {
        return $this->inscription?->devoirs ?? new Collection();
    }

    public function dateNaissance(): Carbon
    {
        return Carbon::parse($this->date_naissance);
    }

    public function getAgeAttribute(): int
    {
        return $this->dateNaissance()->age;
    }
}
