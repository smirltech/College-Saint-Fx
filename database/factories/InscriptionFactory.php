<?php

namespace Database\Factories;

use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Inscription>
 */
class InscriptionFactory extends Factory
{
    protected $model = Inscription::class;

    public function definition(): array
    {

        return [
            'eleve_id' => $this->faker->unique()->randomElement(Eleve::pluck('id')->toArray()),
            'classe_id' => $this->faker->randomElement(Classe::pluck('id')->toArray()),
            'annee_id' => Annee::id(),
            'categorie' => $this->faker->randomElement(array_column(InscriptionCategorie::cases(), 'value')),
            'montant' => 10000,
            'status' => InscriptionStatus::approved,
        ];
    }
}
