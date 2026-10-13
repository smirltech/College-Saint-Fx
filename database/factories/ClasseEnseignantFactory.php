<?php

namespace Database\Factories;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseEnseignant;
use App\Models\Enseignant;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<ClasseEnseignant>
 */
class ClasseEnseignantFactory extends Factory
{

    protected $model = ClasseEnseignant::class;

    public function definition()
    {
        return [
            'classe_id' => $this->faker->numberBetween(1, Classe::count()),
            'enseignant_id' => $this->faker->randomElement(Enseignant::pluck('id')->toArray()),
            'annee_id' => Annee::id(),
        ];
    }
}
