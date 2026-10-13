<?php

namespace App\Models;

use App\Enums\MaterialStatus;
use App\Enums\MouvementStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Materiel extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'status' => MaterialStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = [
        'mouvements',
    ];

    public function category(): BelongsTo
    {
        return $this->belongsTo(MaterielCategory::class, 'materiel_category_id', 'id');
    }

    public function mouvements(): HasMany
    {
        return $this->hasMany(Mouvement::class)->orderBy('date', 'DESC');
    }

    public function getCategoryIdAttribute(): int|null
    {
        return $this->category->id;
    }

    public function getCategoryNomAttribute(): string|null
    {
        return $this->category->nom;
    }

    public function getVieConsommeeAttribute(): int|null
    {
        if ($this->date == null) {
            return null;
        }
        $n0 = Carbon::parse($this->date);
        $n = Carbon::now();

        return $n->diffInYears($n0, absolute: true);
    }

    public function getVieRestanteAttribute(): int|null
    {
        if ($this->date == null) {
            return null;
        }
        $n0 = Carbon::parse($this->date);
        $n = Carbon::now();
        $d = $n->diffInYears($n0, absolute: true);

        return $d > $this->vie ? $this->vie : $this->vie - $d;
    }

    public function getDateFormattedAttribute(): string|null
    {
        return $this->date == null ? null : Carbon::parse($this->date)->format('d-m-Y');
    }

    public function getDirectionAttribute(): MouvementStatus|null
    {
        return $this->mouvements?->first()?->direction;
    }

    public function getAmortissementAttribute(): float|null
    {
        return $this->amortissementTaux == null ? null : ($this->montant * $this->amortissementTaux / 100);
    }

    public function getAmortissementCumuleAttribute(): float|null
    {
        return $this->amortissement == null ? null : $this->amortissement * $this->vie_consommee;
    }

    public function getValeurResiduelleAttribute(): float|null
    {
        return $this->amortissement_cumule == null ? null : $this->montant - $this->amortissement_cumule;
    }

    public function getAmortissementTauxAttribute(): float|null
    {
        return $this->vie == null ? null : (100 / $this->vie);
    }

    public function genererTableAmortissements(): array
    {
        $base = [];
        if ($this->date == null) {
            return $base;
        }
        $annee0 = Carbon::parse($this->date)->year;
        $amoCum = 0;
        for ($i = 1; $i <= $this->vie; $i++) {
            $anneeX = $annee0 + $i;
            $amoCum += $this->amortissement;

            $amo = new \App\Helpers\Amortissement();
            $amo->annee = $anneeX;
            $amo->amortissement = $this->amortissement;
            $amo->amortissementCumul = $amoCum;
            $amo->residu = $this->montant - $amoCum;
            $amo->atteint = $this->vie_consommee >= $i;

            $base[] = $amo;
        }
        // an array of arrays
        return $base;
    }
}
