<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Depense;
use App\Models\DepenseType;
use App\Models\Perception;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perception>
 */
class DepenseFactory extends Factory
{
    protected $model = Depense::class;

    public function definition(): array
    {
        return [
            'depense_type_id' => $this->faker->randomElement(DepenseType::pluck('id')->toArray()),
            'montant' => $this->faker->randomNumber(2) * 1000,
            'note' => $this->faker->sentence(6),
            'reference' => $this->faker->randomNumber(6),
            'annee_id' => Annee::id(),
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'status' => $this->faker->randomElement(['pending', 'issued', 'done']),
        ];
    }
}
