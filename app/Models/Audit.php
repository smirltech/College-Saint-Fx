<?php

namespace App\Models;

use App\Enums\AuditEvent;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;
use Illuminate\Support\Str;

class Audit extends Model implements \OwenIt\Auditing\Contracts\Audit
{
    use \OwenIt\Auditing\Audit, HasUlids;


    protected $guarded = [];

    protected $casts = [
        'event' => AuditEvent::class,
        'old_values' => 'json',
        'new_values' => 'json',
        'auditable_id' => 'integer',
    ];

    // create a createdAt attribute use dif for human-readable date
    public function getDisplayDateAttribute(): string
    {
        return Carbon::parse($this->created_at)->diffForHumans();
    }

    public function getDisplayAuditableAttribute(): ?string
    {
        return Str::limit($this?->auditable, 100);
    }
}
