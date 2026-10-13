<?php

namespace Database\Factories;

use App\Models\Cours;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cours>
 */
class CoursFactory extends Factory
{
    protected $model = Cours::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->sentence(3),
            'description' => $this->faker->paragraph(1),
            'section_id' => $this->faker->numberBetween(1, Section::count()),
        ];
    }
}
