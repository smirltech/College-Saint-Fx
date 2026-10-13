<?php

namespace Database\Factories;

use App\Enums\ResultatType;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Resultat;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Resultat>
 */
class ResultatFactory extends Factory
{
    protected $model = Resultat::class;

    public function definition()
    {
       $inscription = Inscription::find($this->faker->randomElement(Inscription::pluck('id')->toArray()));
        return [
            'custom_property' => $this->faker->randomElement(ResultatType::cases()), //$this->faker->word,
            'pourcentage' => $this->faker->randomFloat(2, 0, 100),
            'place' => $this->faker->numberBetween(1, 10),
            'annee_id' => Annee::id(),
            'classe_id' => $inscription->classe_id,
            'inscription_id' => $inscription->id,
        ];
    }
}
