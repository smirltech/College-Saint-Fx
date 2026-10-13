<?php

namespace Database\Seeders;

use App\Models\Unit;
use Illuminate\Database\Seeder;

class UnitSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->data() as $depense) {
            Unit::create($depense);
        }
    }

    private function data(): array
    {
        return [
            [
                'nom' => 'Kilogramme',
                'code' => 'Kg',
            ],
            [
                'nom' => 'Mètre',
                'code' => 'm',
            ],
            [
                'nom' => 'Litre',
                'code' => 'L',
            ],
            [
                'nom' => 'Carton',
                'code' => 'Ctn',
            ],
            [
                'nom' => 'Pièce',
                'code' => 'Pc',
            ],
            [
                'nom' => 'Bouteille',
                'code' => 'Btl',
            ],
            [
                'nom' => 'Boîte',
                'code' => 'Bte',
            ],
            [
                'nom' => 'Paquet',
                'code' => 'Pqt',
            ],
            [
                'nom' => 'Sac',
                'code' => 'Sac',
            ]
        ];
    }
}
