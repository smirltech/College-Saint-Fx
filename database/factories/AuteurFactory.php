<?php

namespace Database\Factories;

use App\Enums\Sexe;
use App\Models\Auteur;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Auteur>
 */
class AuteurFactory extends Factory
{
    protected $model = Auteur::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->name(),
            'prenom' => fake()->firstName(),
            'sexe' => fake()->randomElement(Sexe::cases()),
        ];
    }
}
