<?php

namespace Database\Factories;

use App\Enums\DevoirStatus;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Cours;
use App\Models\Devoir;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Devoir>
 */
class DevoirFactory extends Factory
{
    protected $model = Devoir::class;

    public function definition()
    {
        return [
            'classe_id' => $this->faker->numberBetween(1, Classe::count()),
            'cours_id' => $this->faker->numberBetween(1, Cours::count()),
            'annee_id' => Annee::id(),
            'titre' => $this->faker->words(3, true),
            'contenu' => $this->faker->paragraphs(5, true),
            'echeance' => $this->faker->dateTimeBetween('now', '+1 week'),
            'status' => $this->faker->randomElement(array_column(DevoirStatus::cases(), 'value')),
        ];
    }
}
