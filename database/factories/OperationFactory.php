<?php

namespace Database\Factories;

use App\Enums\MouvementStatus;
use App\Models\Consommable;
use App\Models\Operation;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Operation>
 */
class OperationFactory extends Factory
{
    protected $model = Operation::class;

    public function definition()
    {
        return [
            'consommable_id' => $this->faker->randomElement(Consommable::pluck('id')->toArray()),
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'facilitateur_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'beneficiaire' => $this->faker->name,
            'quantite' => $this->faker->randomNumber(2),
            'date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'direction' => $this->faker->randomElement(MouvementStatus::cases()),
            'observation' => $this->faker->sentence,
        ];
    }
}
