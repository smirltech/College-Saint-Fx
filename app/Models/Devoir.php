<?php

namespace App\Models;

use App\Enums\DevoirStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use SmirlTech\LaravelMedia\Traits\HasMedia;

class Devoir extends Model
{
    use HasFactory, HasUlids, HasMedia;

    // set annee on create in not set in boot
    public $guarded = [];

    protected $casts = [
        //'echeance' => 'date',
        'status' => DevoirStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::retrieved(function (self $devoir) {
            // change status to closed if echance is after now
            // use carbon to compare dates
            if (Carbon::now()->greaterThan($devoir->echeance)) {
                $devoir->status = DevoirStatus::closed;
                $devoir->save();
            }
            if (Carbon::now()->lessThan($devoir->echeance) and $devoir->status == DevoirStatus::closed) {
                $devoir->status = DevoirStatus::open;
                $devoir->save();
            }

        });

        static::creating(function (self $model) {
            $model->annee_id = $model->annee_id ?? Annee::id();
        });
    }

    public function getDocumentAttribute(): ?Media
    {
        return $this->getDocument();
    }

    public function getDocument(): ?Media
    {
        return $this->getFirstMedia();
    }

    // get Document attribute
    public function getDocumentUrlAttribute(): string
    {
        return $this->getFirstMediaUrl();
    }

    // get devoirEleves relation
    public function devoirReponses(): HasMany
    {
        return $this->hasMany(DevoirReponse::class);
    }

    // cours
    public function cours(): BelongsTo
    {
        return $this->belongsTo(Cours::class);
    }

    // classe
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    // display echeance
    public function getEcheanceDisplayAttribute(): string
    {
        return Carbon::parse($this->echeance)->diffForHumans();
    }

    /* public function getEcheanceAttribute($value = null): string
     {
         return Carbon::parse($value)->format('Y-m-d');
     }*/

    // get reponses attribute
    public function getReponsesAttribute(): Collection
    {
        return $this->devoirReponses;
    }

    // isClosed
    public function isClosed(): bool
    {
        return $this->status == DevoirStatus::closed;
    }
}
