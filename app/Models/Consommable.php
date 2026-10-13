<?php

namespace App\Models;

use App\Enums\MouvementStatus;
use App\Helpers\Helpers;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Str;

class Consommable extends Model
{
    use HasFactory;

    public $guarded = [];

    public $with = ['operations'];


    protected static function booted(): void
    {
        self::creating(function (Consommable $consommable) {
            if ($consommable->code == null) {
                $consommable->code = self::generateCode();
            }
        });
    }

    public static function generateCode(): string
    {

        $part1 = "CENK-" . date('Y');

        $count = Consommable::where('code', 'like', $part1 . '%')->count() + 1;

        $part2 = Str::padLeft($count, 4, '0');
        return "{$part1}-C{$part2}";
    }

    public function unit(): BelongsTo
    {
        return $this->belongsTo(Unit::class);
    }

    public function getQuantiteInAttribute(): int|null
    {
        return $this->operations()->where('direction', MouvementStatus::in->name)->sum('quantite');

    }

    public function operations(): HasMany
    {
        return $this->hasMany(Operation::class)->orderBy('date', 'DESC');
    }

    public function getQuantiteOutAttribute(): int|null
    {
        return $this->operations()->where('direction', MouvementStatus::out->name)->sum('quantite');

    }

    public function getQuantiteAttribute(): int
    {
        return (int)($this->quantiteIn ?? 0) - (int)($this->quantiteOut ?? 0);
    }

    /**
     * Le pourcentage du stock restant par rapport au stock minimum
     * Quand le stock minimum est 0 ou n'est pas donné, le pourcentage est toujours 100
     */
    public function getAlertRateAttribute(): int
    {
        return $this->stock_minimum == null || $this->stock_minimum == 0 ? 100 : (((int)($this->quantite ?? 0) / (int)($this->stock_minimum)) * 100) - 100;
    }

    public function getAlertTextAttribute(): string
    {
        return Helpers::textAlert($this->alertRate);
    }

    public function getAlertColorAttribute(): string
    {
        return Helpers::colorAlert($this->alertRate);
    }

    public function getAlertColorWithDefaultPrimaryAttribute(): string
    {
        return strlen($this->alertColor) == 0 ? 'primary' : $this->alertColor;
    }
}
