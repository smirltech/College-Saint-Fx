<?php

namespace Database\Seeders;

use App\Models\Annee;
use App\Models\Frais;
use Illuminate\Database\Seeder;

class FraisSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->data() as $frais) {
            Frais::create($frais);
        }
    }

    private function data(): array
    {
        return [
            [
                'nom' => 'Frais d\'inscription',
                'montant' => 15,
                'annee_id' => Annee::id(),
            ],

            [
                'nom' => 'Minerval',
                'montant' => 50,
                'annee_id' => Annee::id(),
            ],
        ];
    }
}
