<?php

namespace Database\Factories;

use App\Models\MaterielCategory;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<MaterielCategory>
 */
class MaterielCategoryFactory extends Factory
{
    protected $model = MaterielCategory::class;

    public function definition()
    {
        return [
            'materiel_category_id' => $this->faker->randomElement(MaterielCategory::pluck('id')->toArray()),
            'nom' => $this->faker->unique()->word(),
            'description' => $this->faker->text(),
        ];
    }
}
