<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Perception;
use App\Models\Revenu;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perception>
 */
class RevenuFactory extends Factory
{
    protected $model = Revenu::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->sentence(2),
            'description' => $this->faker->sentence(6),
            'montant' => $this->faker->randomNumber(2) * 1000,
            'annee_id' => Annee::id(),
        ];
    }
}
