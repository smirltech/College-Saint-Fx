<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ClasseEnseignant extends Model
{
    use HasFactory;

    public $guarded = [];

    protected static function boot()
    {
        parent::boot();

        static::saving(function (ClasseEnseignant $classe_enseignant) {
            $classe_enseignant->annee_id = Annee::encours()->id;
        });
    }
}
