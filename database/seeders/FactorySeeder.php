<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use App\Models\Amortissement;
use App\Models\Auteur;
use App\Models\Cession;
use App\Models\ClasseEnseignant;
use App\Models\Consommable;
use App\Models\Cours;
use App\Models\CoursEnseignant;
use App\Models\Depense;
use App\Models\Devoir;
use App\Models\DevoirReponse;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Inscription;
use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Models\Mouvement;
use App\Models\Operation;
use App\Models\Ouvrage;
use App\Models\Paiment;
use App\Models\Perception;
use App\Models\Presence;
use App\Models\Rayon;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Models\Resultat;
use App\Models\Revenu;
use App\Models\User;
use Database\Factories\UnitFactory;
use Exception;
use Illuminate\Database\Seeder;

class FactorySeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run(): void
    {
        try {
            User::factory(5)->create();

            Eleve::factory(50)->create();
            Inscription::factory(10)->create();

            Responsable::factory(10)->create();
            ResponsableEleve::factory(10)->create();

            Enseignant::factory(10)->create();
            ClasseEnseignant::factory(10)->create();

            Cours::factory(10)->create();
            CoursEnseignant::factory(20)->create();

            Presence::factory(10)->create();

           // Resultat::factory(10)->create();

            //Devoir::factory(10)->create();
           // DevoirReponse::factory(10)->create();

            # Finance
            Revenu::factory(10)->create();
            Depense::factory(10)->create();
            Paiment::factory(10)->create();
            Perception::factory(10)->create();
            MaterielCategory::factory(5)->create();
            Materiel::factory(10)->create();
            Mouvement::factory(15)->create();
            Cession::factory(3)->create();
            Consommable::factory(10)->create();
            Operation::factory(10)->create();
            Auteur::factory(5)->create();
            Rayon::factory(5)->create();
            Ouvrage::factory(20)->create();
        } catch (Exception $e) {
            echo $e->getMessage();
        }

    }
}
