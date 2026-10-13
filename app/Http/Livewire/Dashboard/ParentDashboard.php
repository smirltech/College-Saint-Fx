<?php

namespace App\Http\Livewire\Dashboard;

use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Perception;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class ParentDashboard extends Component
{
    public function mount(): void
    {

        $this->boxes = $this->getBoxes();
    }

    private function getBoxes(): array
    {
        $this->anneeEncours = Annee::encours();

        //TODO: we should consider removing the fallback to all eleves
        $eleves = Auth::user()?->eleves ?? Eleve::all();

        //sum perceptions paid containing the user's eleves
        $perceptionsRequest = Perception::where('annee_id', $this->anneeEncours->id)
            ->whereIn('inscription_id', function ($query) use ($eleves) {
                $query->select('id')
                    ->from('inscriptions')
                    ->whereIn('eleve_id', $eleves->pluck('id'));
            });


        $perceptionsDues = $perceptionsRequest->sum("montant");
        $perceptionsPaid = $perceptionsRequest->sum("paid");


        return [
            [
                'title' => $eleves?->count() ?? 0,
                'text' => 'Eleves',
                'icon' => 'fas fa-graduation-cap',
                'theme' => 'gradient-primary',
                'url' => '#'

            ],
            [
                'title' => '$' . $perceptionsPaid,
                'text' => 'Depenses',
                'icon' => 'fas fa-credit-card',
                'theme' => 'gradient-danger',
                'url' => '#'

            ],
            [
                'title' => '$ ' . $perceptionsDues,
                'text' => 'Frais impayées',
                'icon' => 'fas fa-money-bill-wave',
                'url' => "#",
                'theme' => 'primary',
            ],
        ];
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.dashboard.parent-dashboard');
    }
}
