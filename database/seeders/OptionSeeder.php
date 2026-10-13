<?php

namespace Database\Seeders;

use App\Models\Option;
use Illuminate\Database\Seeder;

class OptionSeeder extends Seeder
{
    public function run(): void
    {
//        Option::truncate();
        foreach ($this->data() as $faculte) {
            Option::create($faculte);
        }
    }

    private function data(): array
    {
        return [
            [
                'nom' => 'Etudes de Base',
                'code' => 'EB',
            ],
            [
                'nom' => 'Humanités Scientifiques',
                'code' => 'SC',

            ],
            [
                'nom' => 'Techniques Coupe et Couture',
                'code' => 'CC',
            ],
            [
                'nom' => 'Humanités Commerciales et Gestion',
                'code' => 'CG',
            ],
            [
                'nom' => 'Humanités Eléctricité',
                'code' => 'EL',
            ],
        ];
    }
}
