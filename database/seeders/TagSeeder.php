<?php

namespace Database\Seeders;


use App\Models\Tag;
use Illuminate\Database\Seeder;

class TagSeeder extends Seeder
{
    public function run(): void
    {
        foreach ($this->data() as $etiquette) {
            Tag::create($etiquette);
        }
    }

    private function data()
    {
        return [
            [
                'name' => 'Sciences',
            ],
            [
                'name' => 'Langue',
            ],
            [
                'name' => 'Technologie',
            ],
            [
                'name' => 'Connaissance Générale',
            ],
            [
                'name' => 'Biologie',
            ],
            [
                'name' => 'Électricité',
            ],
            [
                'name' => 'Français',
            ],
            [
                'name' => 'Agriculture',
            ],
        ];
    }
}
