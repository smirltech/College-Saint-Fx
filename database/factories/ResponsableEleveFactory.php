<?php

namespace Database\Factories;

use App\Enums\ResponsableRelation;
use App\Models\Eleve;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ResponsableEleve>
 */
class ResponsableEleveFactory extends Factory
{
    protected $model = ResponsableEleve::class;

    public function definition(): array
    {
        return [
            'responsable_id' => $this->faker->randomElement(Responsable::pluck('id')->toArray()),
            'eleve_id' => $this->faker->randomElement(Eleve::pluck('id')->toArray()),
            'relation' => $this->faker->randomElement(array_column(ResponsableRelation::cases(), 'value')),
        ];
    }
}
