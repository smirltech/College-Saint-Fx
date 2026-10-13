<?php

namespace Database\Seeders;

use App\Enums\ClasseNiveau;
use App\Models\Classe;
use App\Models\Option;
use App\Models\Section;
use Illuminate\Database\Seeder;

class ClasseSeeder extends Seeder
{
    public function run()
    {
        foreach ($this->data() as $classe) {
            Classe::create($classe);
        }
    }

    private function data(): array
    {
        return [
            [
                'niveau' => ClasseNiveau::n1,
                'section_id' => 1,
                'code' => '1MAT',
            ],
            [
                'niveau' => ClasseNiveau::n2,
                'section_id' => 1,
                'code' => '2MAT',
            ],
            [
                'niveau' => ClasseNiveau::n3,
                'section_id' => 1,
                'code' => '3MAT',
            ],
            [
                'niveau' => ClasseNiveau::n1,
                'section_id' => 2,
                'code' => '1P',
            ],
            [
                'niveau' => ClasseNiveau::n2,
                'section_id' => 2,
                'code' => '2P',
            ],
            [
                'niveau' => ClasseNiveau::n3,
                'section_id' => 2,
                'code' => '3P',
            ],
            [
                'niveau' => ClasseNiveau::n4,
                'section_id' => 2,
                'code' => '4P',
            ],
            [
                'niveau' => ClasseNiveau::n5,
                'section_id' => 2,
                'code' => '5P',
            ],
            [
                'niveau' => ClasseNiveau::n6,
                'section_id' => 2,
                'code' => '6P',
            ],
        ];
    }
}
