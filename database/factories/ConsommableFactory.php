<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Consommable;
use App\Models\Unit;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Consommable>
 */
class ConsommableFactory extends Factory
{
    protected $model = Consommable::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->unique()->name, //$this->faker->word,
            'description' => $this->faker->paragraph,
            'stock_minimum' => $this->faker->randomNumber(2),
            'unit_id' => $this->faker->randomElement(Unit::pluck('id')->toArray()),
            'annee_id' => Annee::id(),
        ];
    }
}
