<?php

namespace App\Http\Livewire;

use App\Traits\TopMenuPreview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class MainDashboardComponent extends Component
{
    use TopMenuPreview;

    public $boxes = [];

    public function mount(): void
    {
        // return redirect(LoginController::redirectTo());

        $this->boxes = [
            [
                'title' => "Scolarité",
                'text' => 'Gestion scolaire',
                'icon' => 'fas fa-fw fa-user-graduate',
                'url' => route('scolarite'),
                'theme' => 'danger',
            ],
            [
                'title' => "Finance",
                'text' => 'Gestion des finances',
                'icon' => 'fas fa-fw fa-arrow-trend-up',
                'url' => route('finance'),
                'theme' => 'primary',
            ],
            [
                'title' => "Logistique",
                'text' => 'Gestion du patrimoine',
                'icon' => 'fas fa-fw fa-recycle',
                'url' => route('logistique'),
                'theme' => 'warning',
            ],
            [
                'title' => "Bibliotheque",
                'text' => 'Gestion de la bibliotheque',
                'icon' => 'fas fa-fw fa-book',
                'url' => route('bibliotheque'),
                'theme' => 'success',
            ],

        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.dashboard')->layoutData(['title' => 'Accueil']);
    }

}
