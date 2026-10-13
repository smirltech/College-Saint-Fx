<?php

namespace App\Models;

use App\Enums\PresenceStatus;
use Carbon\Carbon;
use DateTime;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use LaracraftTech\LaravelDateScopes\DateScopes;
use SmirlTech\LaravelFullcalendar\Event;

class Presence extends Model
{
    use HasFactory, HasUlids, DateScopes;

    public $guarded = [];

    protected static function booted(): void
    {
        static::creating(function (Presence $presence) {
            if ($presence->annee_id == null) {
                $presence->annee_id = Annee::id();
            }
        });
    }


    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }

    public static function lastTotal(): int
    {
        $mat = self::maternelle()->where('date', self::maternelle()->max('date'))->sum('total');
        $p = self::primaire()->where('date', self::primaire()->max('date'))->sum('total');
        $sec = self::secondaire()->where('date', self::secondaire()->max('date'))->sum('total');
        return $mat + $p + $sec;
    }

    public function scopeMaternelle($query)
    {
        return $query->whereHas('classe', function ($q1) {
            $q1->whereHas('section', function ($q2) {
                $q2->where('code', \App\Enums\Section::MATERNELLE);
            });
        });
    }

    public function scopePrimaire($query)
    {
        return $query->whereHas('classe', function ($q1) {
            $q1->whereHas('section', function ($q2) {
                $q2->where('code', \App\Enums\Section::PRIMAIRE);
            });
        });
    }

    public function scopeSecondaire($query)
    {
        return $query->whereHas('classe', function ($q1) {
            $q1->whereHas('section', function ($q2) {
                $q2->where('code', \App\Enums\Section::SECONDAIRE);
            });
        });
    }


}
