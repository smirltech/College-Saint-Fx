<?php

namespace App\Traits;

use App\Models\Annee;

trait HasScopeAnnee
{
    public static function scopeAnnee($query, $annee_id = null)
    {
        return self::scopeAnneeScolaire($query, $annee_id);
    }

    public static function scopeAnneeScolaire($query, $annee_id = null)
    {
        if ($annee_id) {
            return $query->where('annee_id', $annee_id);
        }
        return $query->where('annee_id', Annee::id());
    }
}
