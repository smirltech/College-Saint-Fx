<?php

namespace App\Http\Livewire\Scolarite;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Enseignant;
use App\Models\Responsable;
use App\Traits\TopMenuPreview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardComponent extends Component
{
    use TopMenuPreview;

    public $boxes = [];

    public $annee_courante;

    public function mount(): void
    {
        // set user email vefied if not yet
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::user()->update(['email_verified_at' => now()]);
        }

        $start_year = Annee::encours()->start_year;


        $eleves = Eleve::count();
        $parents = Responsable::count();

        $classes = Classe::count();
        $enseignants = Enseignant::count();

        $anneeEleves = Eleve::where('created_at', '>', $start_year)->count();
        $anneeParents = Responsable::where('created_at', '>', $start_year)->count();
        $anneeClasses = Classe::where('updated_at', '>', $start_year)->count();
        $anneeEnseignants = Enseignant::where('created_at', '>', $start_year)->count();


        $rateElevesAnnee = $anneeEleves > 0 ? intval(($eleves / $anneeEleves) * 100) : 0;
        $rateParentsAnnee = $anneeParents > 0 ? intval(($parents / $anneeParents) * 100) : 0;
        $rateClasseAnnee = $anneeClasses > 0 ? intval(($classes / $anneeClasses) * 100) : 0;
        $rateEnseignantsAnnee = $anneeEnseignants > 0 ? intval(($enseignants / $anneeEnseignants) * 100) : 0;

        $this->boxes = [
            [
                'title' => $anneeEleves,
                'text' => 'Eleves',
                'icon' => 'fa fa-user-graduate',
                'url' => route('scolarite.eleves.index'),
                'theme' => 'primary',
                'rate' => "$rateElevesAnnee%",
                'subtitle' => "+{$rateElevesAnnee}% cette année",

            ],
            [
                'title' => $anneeParents,
                'text' => 'Parents',
                'icon' => 'fa fa-person-pregnant',
                'url' => route("scolarite.responsables.index", 'approved'),
                'theme' => 'info',
                'rate' => "$rateParentsAnnee%",
                'subtitle' => "+$rateParentsAnnee% cette année",
            ],
            [
                'title' => $anneeClasses,
                'text' => 'Classes',
                'icon' => 'fa fa-person-chalkboard',
                'url' => route("scolarite.classes.index", 'rejected'),
                'theme' => 'warning',
                'rate' => "$rateClasseAnnee%",
                'subtitle' => "+$rateClasseAnnee% cette année",
            ],
            [
                'title' => $anneeEnseignants,
                'text' => 'Ensignants',
                'icon' => 'fa fa-chalkboard-teacher',
                'url' => route("scolarite.enseignants.index", 'pending'),
                'theme' => 'success',
                'rate' => "$rateEnseignantsAnnee%",
                'subtitle' => "+$rateEnseignantsAnnee% cette année",
            ]
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.dashboard')->layoutData(['title' => 'Scolarité']);
    }

}
