<?php

namespace App\Models;

use App\Enums\MouvementStatus;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Operation extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'direction' => MouvementStatus::class,
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

    public function consommable(): BelongsTo
    {
        return $this->belongsTo(Consommable::class);
    }

    public function getDateFormattedAttribute(): string|null
    {
        return $this->date == null ? null : Carbon::parse($this->date)->format('d-m-Y');
    }
}
