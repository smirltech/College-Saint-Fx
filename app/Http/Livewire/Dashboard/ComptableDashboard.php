<?php

namespace App\Http\Livewire\Dashboard;

use App\Helpers\Helpers;
use App\Models\Annee;
use App\Models\Depense;
use App\Models\Inscription;
use App\Models\Perception;
use App\Models\Revenu;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Pharaonic\Laravel\Readable\Readable;

class ComptableDashboard extends Component
{
    public function mount(): void
    {

        $this->boxes = $this->getBoxes();
    }

    private function getBoxes(): array
    {
        $this->anneeEncours = Annee::encours();


        $monthTo = Carbon::now()->endOfMonth();
        $monthFrom = $monthTo->copy()->subMonth()->subDay()->addSecond();

        //dd("$monthFrom === $monthTo");

        // todo: we should consider annee_id wh en fetching data
        $revenuTotalSum = Revenu::where('annee_id', $this->anneeEncours->id)->sum("montant");
        $revenuMonthSum = Perception::paid()/*->whereBetween('created_at', [$monthFrom, $monthTo])*/ ->sum("montant");
        $rateRevenuMonth = $revenuTotalSum <= 0 ? 0 : intval($revenuMonthSum / $revenuTotalSum * 100);

        $depenseTotalSum = Depense::where('annee_id', $this->anneeEncours->id)->sum("montant");
        $depenseMonthSum = Depense::where('annee_id', $this->anneeEncours->id)->whereBetween('created_at', [$monthFrom, $monthTo])->sum("montant");
        $rateDepenseMonth = $depenseTotalSum <= 0 ? 0 : intval($depenseMonthSum / $depenseTotalSum * 100);

        $perceptionsRequest = Perception::where('annee_id', $this->anneeEncours->id);
        $perceptions = $perceptionsRequest->get();
        $perceptionsDues = $perceptionsRequest->sum("montant");
        $perceptionsPaid = $perceptionsRequest->sum("paid");
        $perceptionSold = $perceptionsDues - $perceptionsPaid;
        $ratePerceptionSold = $perceptionsDues <= 0 ? 0 : intval($perceptionSold / $perceptionsDues * 100);

        $taux = $perceptionsDues <= 0 ? 0 : intval(100 - ($perceptionsPaid / $perceptionsDues) * 100, 1);

        return [
            [
                'title' => Inscription::anneeScolaire()->count(),
                'text' => 'Eleves',
                'icon' => 'fas fa-graduation-cap',
                'theme' => 'gradient-primary',
                'url' => '#'

            ],
            [
                'title' => '$' . $depenseTotalSum,
                'text' => 'Depenses',
                'icon' => 'fas fa-credit-card',
                'theme' => 'gradient-danger',
                'url' => '#'

            ],
            [
                'title' => '$' . $perceptionsPaid,
                'text' => 'Revenus',
                'icon' => 'fas fa-coins',
                'theme' => 'gradient-success',
                'url' => '#'

            ],
            [
                'title' => '$ ' . Readable::getHumanNumber($perceptionsDues, showDecimal: true, decimals: 2) . ' / ' . $perceptionsPaid <= 0 ? 0 : intval(100 - ($perceptionsPaid / $perceptionsDues) * 100, 1) . '%',
                'text' => 'Frais impayées',
                'icon' => 'fas fa-money-bill-wave',
                'url' => "#",
                'theme' => 'primary',
                'rate' => "{$taux}",
                'subtitle' => "de " . Helpers::currencyFormat($perceptionsDues, symbol: 'Fc') . " cette année scolaire",
            ],
        ];
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.dashboard.comptable-dashboard');
    }
}
