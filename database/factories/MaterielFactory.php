<?php

namespace Database\Factories;

use App\Enums\MaterialStatus;
use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Materiel>
 */
class MaterielFactory extends Factory
{
    protected $model = Materiel::class;

    public function definition()
    {
        return [
            'materiel_category_id' => $this->faker->randomElement(MaterielCategory::pluck('id')->toArray()),
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'edited_by' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'nom' => $this->faker->unique()->word(),
            'description' => $this->faker->text(),
            'montant' => $this->faker->numberBetween(10000, 100000),
            'date' => $this->faker->dateTimeBetween('-3 years', 'now')->format('Y-m-d'),
            'vie' => $this->faker->numberBetween(1, 5),
            'status' => MaterialStatus::ok->name,
        ];
    }
}
