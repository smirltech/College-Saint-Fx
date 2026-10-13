<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class OuvrageAuteur extends Model
{
    use HasFactory;

    public $guarded = [];

    public function auteur(): BelongsTo|null
    {
        return $this->belongsTo(Auteur::class);
    }

    public function getNomAttribute(): string|null
    {
        return $this->auteur->nom;
    }

    public function ouvrage(): BelongsTo|null
    {
        return $this->belongsTo(Ouvrage::class);
    }
}
