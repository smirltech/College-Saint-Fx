<?php

namespace Database\Factories;

use App\Models\Ouvrage;
use App\Models\Rayon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Ouvrage>
 */
class OuvrageFactory extends Factory
{
    protected $model = Ouvrage::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'rayon_id' => $this->faker->randomElement(Rayon::pluck('id')->toArray()),
            'titre' => fake()->text(20),
            'sous_titre' => fake()->text(20),
            'resume' => fake()->paragraph(3),
            'edition' => fake()->text(10),
            'lieu' => fake()->city(),
            'editeur' => fake()->company(),
            'date' => fake()->date(),
            'url' => fake()->url(),
        ];
    }
}
