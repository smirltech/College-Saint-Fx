<?php

namespace App\Models;

use App\Enums\Sexe;
use Illuminate\Database\Eloquent\Concerns\HasUlids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Responsable extends Model
{
    use HasFactory, HasUlids;

    public $guarded = [];

    protected $casts = [
        'sexe' => Sexe::class,
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function responsable_eleves()
    {
        return $this->hasMany(ResponsableEleve::class);
    }

    public function user(): BelongsTo|null
    {
        return $this->belongsTo(User::class);
    }

    public function getElevesAttribute()
    {
        return $this->responsable_eleves->map(fn ($eleve) => $eleve->eleve);
    }

    public function getDetailAttribute(): string
    {
        return "{$this->nom} - Phone:({$this->telephone}) - Adresse:({$this->adresse})";
    }
}
