<?php

namespace App\Models;

use App\Enums\DepenseStatus;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Spatie\ModelStatus\Status as SpatieStatus;

class Status extends SpatieStatus
{
    use HasUlids;

    public $guarded = [];

    public function getLabelAttribute(): ?string
    {
        return DepenseStatus::tryFrom($this->name)?->label();
    }

    public function getColorAttribute(): ?string
    {
        return DepenseStatus::tryFrom($this->name)?->color();
    }

    // user
    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }
}
