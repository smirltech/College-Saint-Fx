<?php

namespace App\Http\Livewire\Dashboard;

use App\Enums\Devise;
use App\Enums\UserRole;
use App\Helpers\Helpers;
use App\Models\Consommable;
use App\Models\Depense;
use App\Models\Enseignant;
use App\Models\Inscription;
use App\Models\Materiel;
use App\Models\Perception;
use App\Models\Presence;
use App\Models\Revenu;
use App\Models\User;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Routing\Route;
use Livewire\Component;
use Pharaonic\Laravel\Readable\Readable;

class AdminDashboardComponent extends Component
{

    public $devise = null;
    public function mount(): void
    {
        $this->boxes = $this->getBoxes();
    }

    private function getBoxes(): array
    {
        $perceptionsUSD = Helpers::currencyFormat(Perception::whereDevise('USD')->sum('montant'));
        $perceptionsCDF = Helpers::currencyFormat((Perception::whereDevise('CDF')->sum('montant')));

        $depensesUSD = Helpers::currencyFormat((Depense::whereDevise('USD')->sum('montant')));
        $depensesCDF = Helpers::currencyFormat(Depense::whereDevise(Devise::CDF)->sum('montant'));


        $presences = Presence::lastTotal();
        $inscriptions = Inscription::anneeScolaire()->count();


        return [
            [
                'title' => "{$presences} / {$inscriptions}",
                'text' => 'Elèves',
                'icon' => 'fas fa-graduation-cap',
                'theme' => 'gradient-primary',
                'url' => '#'

            ],
            [
                'title' => "{$perceptionsUSD}$ / {$perceptionsCDF}Fc",
                'text' => 'Perceptions',
                'icon' => 'fas fa-coins',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
            [
                'title' => Enseignant::count(),
                'text' => 'Enseignants',
                'icon' => 'fas fa-chalkboard-teacher',
                'theme' => 'gradient-info',
                'url' => '#'

            ],
            [
                'title' => User::count(),
                'text' => 'Personnels',
                'icon' => 'fas fa-user-tie',
                'theme' => 'gradient-warning',
                'url' => '#'

            ],
            [
                'title' => "{$depensesCDF}Fc / {$depensesUSD}$",
                'text' => 'Depenses',
                'icon' => 'fas fa-credit-card',
                'theme' => 'gradient-danger',
                'url' => '#'

            ],


            [
                'title' => Consommable::count(),
                'text' => 'Consommables',
                'icon' => 'fas fa-utensils',
                'theme' => 'gradient-primary',
                'url' => '#'

            ],
            [
                'title' => Materiel::count(),
                'text' => 'Materiels',
                'icon' => 'fas fa-tools',
                'theme' => 'gradient-warning',
                'url' => '#'

            ]
        ];
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.dashboard.admin-dashboard-component');
    }
}
