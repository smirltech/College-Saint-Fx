<?php

namespace Database\Factories;

use App\Enums\MaterialStatus;
use App\Enums\MouvementStatus;
use App\Models\Materiel;
use App\Models\Mouvement;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Mouvement>
 */
class MouvementFactory extends Factory
{
    protected $model = Mouvement::class;

    public function definition()
    {

        return [
            'materiel_id' => $this->faker->randomElement(Materiel::pluck('id')->toArray()),
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'facilitateur_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'beneficiaire' => $this->faker->name,
            'date' => $this->faker->dateTimeBetween('-2 years', 'now')->format('Y-m-d'),
            'direction' => $this->faker->randomElement(MouvementStatus::cases()),
            'materiel_status' => $this->faker->randomElement(MaterialStatus::cases()),
            'observation' => $this->faker->sentence,
        ];
    }
}
