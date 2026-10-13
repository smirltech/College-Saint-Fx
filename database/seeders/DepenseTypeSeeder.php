<?php

namespace Database\Seeders;

use App\Enums\MinervalMonth;
use App\Enums\FraisType;
use App\Models\DepenseType;
use App\Models\Frais;
use Faker\Factory;
use Illuminate\Database\Seeder;

class DepenseTypeSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $depense) {
            DepenseType::create($depense);
        }
    }

    private function data(): array
    {
        $faker = Factory::create();
        return [
            [
                'nom' => "Équipement",
                'description' => $faker->words(3, asText: true),
            ],
            [
                'nom' => "Consommable",
                'description' => $faker->words(3, asText: true),
            ],
            [
                'nom' => "Frais Direct",
                'description' => $faker->words(3, asText: true),
            ],
            [
                'nom' => "Frais Administratif",
                'description' => $faker->words(3, asText: true),
            ],
            [
                'nom' => "Autres",
                'description' => $faker->words(3, asText: true),
            ],
        ];
    }
}
