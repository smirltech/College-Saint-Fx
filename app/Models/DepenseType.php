<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class DepenseType extends Model
{
    use HasFactory;

    public $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime',
    ];

    public function depenses(): HasMany
    {
        return $this->hasMany(Depense::class);
    }

    public function total(): int
    {
        return $this->depenses->where('annee_id', Annee::id())->sum('montant');
    }
}
