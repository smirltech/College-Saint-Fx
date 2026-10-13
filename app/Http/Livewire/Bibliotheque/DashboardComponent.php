<?php

namespace App\Http\Livewire\Bibliotheque;

use App\Models\Ouvrage;
use App\Models\OuvrageAuteur;
use App\Models\Rayon;
use App\Traits\TopMenuPreview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Auth;
use Livewire\Component;

class DashboardComponent extends Component
{
    use TopMenuPreview;

    public $boxes = [];
    public Collection $ouvrages;

    public function mount()
    {
        // set user email vefied if not yet
        if (!Auth::user()->hasVerifiedEmail()) {
            Auth::user()->update(['email_verified_at' => now()]);
        }

        $ouvragesCount = Ouvrage::all()->count();
        $categories = Rayon::all()->count();
        $auteurs = OuvrageAuteur::all()->count();

        $this->ouvrages = Ouvrage::with('lectures')->get()->sortByDesc('lectures_count')->take(5);

        $this->boxes = [
            [
                'title' => $ouvragesCount,
                'text' => 'Ouvrages',
                'icon' => 'fas fa-fw fa-book',
                'url' => route('bibliotheque.ouvrages.index'),
                'theme' => 'success',
            ],
            [
                'title' => $categories,
                'text' => 'Categories',
                'icon' => 'fas fa-fw fa-list',
                'url' => route('bibliotheque.rayons'),
                'theme' => 'warning',
            ],
            [
                'title' => $auteurs,
                'text' => 'Auteurs',
                'icon' => 'fas fa-fw fa-user',
                'url' => route('bibliotheque.auteurs'),
                'theme' => 'primary',
            ],
            /*[
                'title' => count($moisInscritsValid),
                'text' => 'Validés',
                'icon' => 'far fa-bookmark',
                'url' => route("scolarite.inscriptions.status",'approved'),
                'theme' => 'primary',
                'rate' => "$rateInscritsMoisValid%",
                'subtitle' => "+$rateInscritsMoisValid% en 1 mois",
            ],*/
            /*[
                'title' => count($moisInscritsReject),
                'text' => 'Rejetés',
                'icon' => 'far fa-bookmark',
                'url' => route("scolarite.inscriptions.status",'rejected'),
                'theme' => 'warning',
                'rate' => "$rateInscritsMoisReject%",
                'subtitle' => "+$rateInscritsMoisReject% en 1 mois",
            ],*/
            /* [
                 'title' => count($moisInscritspending),
                 'text' => 'En Attente',
                 'icon' => 'far fa-bookmark',
                 'url' => route("scolarite.inscriptions.status", 'pending'),
                 'theme' => 'success',
                 'rate' => "$rateInscritsMoisPending%",
                 'subtitle' => "+$rateInscritsMoisPending% en 1 mois",
             ]*/
        ];
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.bibliotheque.dashboard')->layoutData(['title' => 'Bibliothèque']);
    }

}
