<?php

namespace App\Models;

use App\Enums\MaterialStatus;
use App\Enums\MouvementStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Str;

class Mouvement extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'direction' => MouvementStatus::class,
        'materiel_status' => MaterialStatus::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    protected $with = [
        'facilitateur',
    ];

    public function facilitateur(): BelongsTo
    {
        return $this->belongsTo(User::class, 'facilitateur_id', 'id');
    }

    public function materiel(): BelongsTo
    {
        return $this->belongsTo(Materiel::class);
    }

    public function getDateFormattedAttribute(): string|null
    {
        return $this->date == null ? null : Carbon::parse($this->date)->format('d-m-Y');
    }

    public function getShortObservationAttribute(): string|null
    {
        return Str::limit($this->observation, $limit = 30, $end = '...');
    }
}
