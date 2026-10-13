<?php

namespace Database\Factories;

use App\Enums\Sexe;
use App\Models\Eleve;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Eleve>
 */
class EleveFactory extends Factory
{
    protected $model = Eleve::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->firstName,
            'sexe' => $this->faker->randomElement(array_column(Sexe::cases(), 'value')),
            'date_naissance' => $this->faker->date(),
            'lieu_naissance' => $this->faker->city,
            'adresse' => $this->faker->address,
            'telephone' => $this->faker->phoneNumber,
            'email' => $this->faker->email,
            'section_id' => $this->faker->randomElement(Section::pluck('id')->toArray()),
        ];
    }
}
