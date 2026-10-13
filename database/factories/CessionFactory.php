<?php

namespace Database\Factories;

use App\Models\Cession;
use App\Models\Materiel;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Cession>
 */
class CessionFactory extends Factory
{
    protected $model = Cession::class;

    public function definition()
    {

        return [
            'materiel_id' => $this->faker->randomElement(Materiel::pluck('id')->toArray()),
            'montant' => $this->faker->numberBetween(1000, 5000),
            'date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'observation' => $this->faker->text(),
        ];
    }
}
