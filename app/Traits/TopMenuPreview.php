<?php

namespace App\Traits;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseEnseignant;
use App\Models\CoursEnseignant;
use App\Models\Inscription;
use Illuminate\Support\Facades\Event;
use JeroenNoten\LaravelAdminLte\Events\BuildingMenu;

trait TopMenuPreview
{
    // private $company2;
    public function bootTopMenuPreview()
    {
        # TODO: fix responsive menu on mobile before enabling this
        //  $this->init();
    }

    private function init(): void
    {
        Event::listen(BuildingMenu::class, function (BuildingMenu $event) {
            $aa = Annee::encours();
            if (!$event->menu->itemKeyExists('annee_encours')) {
                $event->menu->add([
                    'key' => 'annee_encours',
                    'text' => "Année scolaire",
                    'label' => $aa->nom,
                    'url' => 'scolarite/annees',
                    'label_color' => 'secondary',
                    'topnav' => true,
                ]);
            }

            if (!$event->menu->itemKeyExists('eleves_inscrits')) {
                $event->menu->add([
                    'key' => 'eleves_inscrits',
                    'text' => "Élèves",
                    'label' => Inscription::getCurrentInscriptions()->count(),
                    'url' => 'scolarite/inscriptions',
                    'label_color' => 'secondary',
                    'topnav' => true,
                ]);
            }

            if (!$event->menu->itemKeyExists('annee_classes')) {
                $event->menu->add([
                    'key' => 'annee_classes',
                    'text' => "Classes",
                    'label' => Classe::all()->count(),
                    'url' => 'scolarite/classes',
                    'label_color' => 'secondary',
                    'topnav' => true,
                ]);
            }

            if (!$event->menu->itemKeyExists('enseignants')) {

                $event->menu->add([
                    'key' => 'enseignants',
                    'text' => "Enseignants",
                    'label' => ClasseEnseignant::all()->count() + CoursEnseignant::all()->count(),
                    'url' => 'scolarite/enseignants',
                    'label_color' => 'secondary',
                    'topnav' => true,
                ]);
            }

        });
    }

}
