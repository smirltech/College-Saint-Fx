<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class CoursEnseignant extends Model
{
    use HasFactory;

    public $guarded = [];

    // saving
    protected static function boot()
    {
        parent::boot();

        static::saving(function (CoursEnseignant $cours_enseignant) {
            $cours_enseignant->annee_id = Annee::encours()->id;
        });
    }

    // cours
    public function cours(): BelongsTo
    {
        return $this->belongsTo(Cours::class);
    }

    // enseignant
    public function enseignant(): BelongsTo
    {
        return $this->belongsTo(Enseignant::class);
    }

    // classe
    public function classe(): BelongsTo
    {
        return $this->belongsTo(Classe::class);
    }
}
