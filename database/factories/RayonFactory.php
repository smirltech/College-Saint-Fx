<?php

namespace Database\Factories;

use App\Models\Rayon;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Rayon>
 */
class RayonFactory extends Factory
{
    protected $model = Rayon::class;

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nom' => fake()->text(20),
            // 'rayon_id' => $this->faker->randomElement(Rayon::pluck('id')->toArray()),
            'description' => fake()->paragraph(3),
        ];
    }
}
