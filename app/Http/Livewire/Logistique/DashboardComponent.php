<?php

namespace App\Http\Livewire\Logistique;

use App\Models\Consommable;
use App\Models\Materiel;
use App\Models\Ouvrage;
use App\Models\OuvrageAuteur;
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

    public function mount()
    {
        // set user email vefied if not yet
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::user()->update(['email_verified_at' => now()]);
        }

        $materiels = Materiel::all()->count();
        $consommables = Consommable::all()->count();
        $auteurs = OuvrageAuteur::all()->count();

        $this->ouvrages = Ouvrage::with('lectures')->get()->sortByDesc('lectures_count')->take(5);

        $this->boxes = [
            [
                'title' => $consommables,
                'text' => 'Consommables',
                'icon' => 'fas fa-fw fa-list',
                'url' => route('logistique.consommables'),
                'theme' => 'primary',
            ],
            [
                'title' => $materiels,
                'text' => 'Materiels',
                'icon' => 'fas fa-fw fa-book',
                'url' => route('logistique.materiels'),
                'theme' => 'success',
            ],

        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.logistiques.dashboard')->layoutData(['title' => 'Logistique']);
    }

}
