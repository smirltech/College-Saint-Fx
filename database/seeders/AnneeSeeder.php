<?php

namespace Database\Seeders;

use App\Models\Annee;
use Illuminate\Database\Seeder;

class AnneeSeeder extends Seeder
{
    public function run(): void
    {
        Annee::updateOrCreate(
            ['date_debut' => "2021-09-05", 'date_fin' => "2022-07-05"],
            ['encours' => false,]
        );
        Annee::updateOrCreate(
            ['date_debut' => "2022-09-05", 'date_fin' => "2023-07-05"],
            ['encours' => true,]
        );
        Annee::updateOrCreate(
            ['date_debut' => "2023-09-05", 'date_fin' => "2024-07-05"],
            ['encours' => false,]
        );
    }
}
