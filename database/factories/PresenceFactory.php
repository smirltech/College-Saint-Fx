<?php

namespace Database\Factories;

use App\Enums\PresenceStatus;
use App\Models\Annee;
use App\Models\Inscription;
use App\Models\Presence;
use Exception;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Presence>
 */
class PresenceFactory extends Factory
{
    protected $model = Presence::class;

    public function definition()
    {
        try {
            return [
                'inscription_id' => $this->faker->randomElement(Inscription::pluck('id')->toArray()),
                'status' => $this->faker->randomElement(PresenceStatus::cases()),
                'date' => $this->faker->unique()->dateTimeBetween('-6 month', 'now'),
                'observation' => $this->faker->sentence(3),
                'annee_id' => Annee::id(),
            ];
        } catch (Exception $e) {
        }
    }
}
