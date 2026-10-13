<?php

namespace Database\Factories;

use App\Enums\MinervalMonth;
use App\Models\Annee;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Perception;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends Factory<Perception>
 */
class PerceptionFactory extends Factory
{
    protected $model = Perception::class;

    public function definition(): array
    {
        $freq = $this->faker->randomElement(MinervalMonth::cases());
        $frais = Frais::find($this->faker->randomElement(Frais::pluck('id')->toArray()));
        // dd($freq);
        return [
            'user_id' => $this->faker->randomElement(User::pluck('id')->toArray()),
            'frais_id' => $frais->id,
            'inscription_id' => $this->faker->randomElement(Inscription::pluck('id')->toArray()),
            'annee_id' => Annee::id(),
            'frais_montant' => $frais->montant,
            'montant' => $this->faker->boolean(60),
        ];
    }
}

