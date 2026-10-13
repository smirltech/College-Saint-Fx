<?php

namespace Database\Factories;

use App\Models\Enseignant;
use App\Models\Section;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Enseignant>
 */
class EnseignantFactory extends Factory
{
    protected $model = Enseignant::class;

    public function definition(): array
    {
        return [
            'nom' => $this->faker->name(),
            'email' => $this->faker->email(),
            'telephone' => $this->faker->phoneNumber(),
            'matricule' => $this->faker->uuid(),
            'section_id' => $this->faker->numberBetween(1, Section::class::count()),
            'adresse' => $this->faker->address(),
            'sexe' => $this->faker->randomElement(['M', 'F']),
            'date_naissance' => $this->faker->date(),
            'lieu_naissance' => $this->faker->city(),
            'nationalite' => $this->faker->country(),
            'niveau' => $this->faker->sentence(3),
            'specialite' => $this->faker->sentence(3),
            'diplome' => $this->faker->sentence(3),
            'date_embauche' => $this->faker->date(),
            'date_depart' => $this->faker->date(),
            'motif_depart' => $this->faker->sentence(3),
            'status' => $this->faker->sentence(3),
        ];
    }
}
