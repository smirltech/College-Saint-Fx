<?php

namespace App\Models;

use App\Enums\ResponsableRelation;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class ResponsableEleve extends Model
{
    use HasFactory, HasUlids;

    public $guarded = [];

    protected $casts = [
        'relation' => ResponsableRelation::class,

    ];

    public function responsable(): BelongsTo
    {
        return $this->belongsTo(Responsable::class);
    }

    public function eleve()
    {
        return $this->belongsTo(Eleve::class);
    }
}
