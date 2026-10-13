<?php

namespace App\Models;

use App\Enums\Devise;
use App\Enums\FraisType;
use App\Enums\MinervalMonth;
use App\Traits\HasScopeAnnee;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Str;
use LaracraftTech\LaravelDateScopes\DateScopes;
use OwenIt\Auditing\Auditable;

class Perception extends Model implements \OwenIt\Auditing\Contracts\Auditable
{
    use HasFactory, HasUlids, SoftDeletes, HasScopeAnnee, DateScopes, Auditable;

    public $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
        'devise' => Devise::class,
        'deleted_at' => 'datetime',
    ];

    protected $with = ['frais'];

    // booted
    public static function total($devise = null)
    {
        return self::when($devise, function ($query) use ($devise) {
            return $query->where('devise', $devise);
        })->sum('montant');
    }

    protected static function booted(): void
    {
        static::creating(function (Perception $model) {
            $model->reference = self::generateReference();
            $model->user_id = $model->user_id ?? auth()->id();
            $model->annee_id = Annee::id();
        });
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getLabelAttribute(): ?string
    {
        if ($this->frais->type == FraisType::MINERVAL) {
            return $this->frais->nom . ' - ' . MinervalMonth::tryFrom($this->custom_property)?->label();
        }

        return $this->frais->nom;
    }

    public static function dataOfLast($days = 7): array
    {
        $data = [];
        for ($i = $days - 1; $i >= 0; $i--) {
            $lDate = Carbon::now()->subDays($i);
            $data[] = self::whereDate('created_at', '=', $lDate)->sum('montant');
        }

        return $data;
    }

    public static function sommeBetween($annee_id, $ddebut, $dfin)
    {
        $debut = Carbon::parse($ddebut)->startOfDay();
        $fin = Carbon::parse($dfin)->endOfDay();

        return self::where('annee_id', $annee_id)->whereBetween('created_at', [$debut, $fin])->sum('montant');
    }

    // eleve through inscription

    public static function scopePaid($query)
    {
        return $query->where('montant', '>', 0);
    }

    public static function scopeUnpaid($query)
    {
        return $query->where('paid', false);
    }


    /**
     * Create a reference for the perception based on the current month and year and the number of perceptions for the current month
     * Model: {count:4 digits}{month:2 digits}{year:2 digits}
     * Ex : 00010123
     */
    public static function generateReference(): string
    {
        $count = self::whereMonth('created_at', Carbon::now()->month)->count();
        $count = Str::padLeft($count + 1, 3, '0');
        $month = Carbon::now()->format('ym');

        return self::checkReference("{$month}{$count}");

    }


    public static function checkReference(string $reference): string
    {
        $count = self::withoutGlobalScopes()->where('reference', $reference)->count();

        if ($count > 0) {
            return self::checkReference(((int)$reference) + 1);
        }
        return $reference;
    }

    public function getEleveAttribute()
    {
        return $this->inscription->eleve;
    }

    public function inscription(): BelongsTo
    {
        return $this->belongsTo(Inscription::class);
    }

    public function frais(): BelongsTo
    {
        return $this->belongsTo(Frais::class);
    }

    public function isCleared(): bool
    {
        if ($this->devise == $this->frais->devise) {
            return $this->frais_montant <= $this->montant;
        }
        if ($this->devise == Devise::CDF && $this->frais->devise == Devise::USD) {
            return $this->frais_montant <= $this->montantUSD();
        }
        return false;
    }

    public function getBalanceAttribute(): float
    {
        // sum of all perceptions for the current year for the inscription and the fraistr
        return $this->inscription->perceptions()->where('frais_id', $this->frais_id)->where('annee_id', Annee::id())->sum('montant');
    }

    public function getResteAttribute(): float
    {
        return $this->montantUSD() - $this->frais_montant;
    }

    public function montantUSD(): float
    {
        return $this->devise == Devise::CDF && $this->frais->devise == Devise::USD ? $this->montant / $this->taux() : $this->montant;
    }

    public function taux(): int
    {
        return (int)$this->taux > 0 ? $this->taux : 2850;
    }

    public function getNomCompletAttribute(): string
    {
        return $this->getFullNameAttribute();
    }

    public function getFullNameAttribute(): string
    {
        return $this->inscription->fullName;
    }

    public function getClasseAttribute(): string
    {
        return $this->inscription->classe->code;
    }

    //scope of cdf
    public function scopeCDF($query)
    {
        return $query->where('devise', Devise::CDF);
    }

    //scope of usd
    public function scopeUSD($query)
    {
        return $query->where('devise', Devise::USD);
    }
}
