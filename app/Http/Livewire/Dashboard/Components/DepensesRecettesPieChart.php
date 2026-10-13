<?php

namespace App\Http\Livewire\Dashboard\Components;

use App\Models\Annee;
use App\Models\Depense;
use App\Models\Perception;
use App\Models\Revenu;
use Carbon\Carbon;
use DivisionByZeroError;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class DepensesRecettesPieChart extends Component
{

    /**
     * @var int|mixed
     */
    public mixed $revenuTotal;
    /**
     * @var int|mixed
     */
    public mixed $depenseTotal;

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $anneeEncours = Annee::encours();


        $monthTo = Carbon::now()->endOfMonth();
        $monthFrom = $monthTo->copy()->subMonth()->subDay()->addSecond();

        //dd("$monthFrom === $monthTo");

        // todo: we should consider annee_id wh en fetching data
        $revenuTotalSum = Revenu::where('annee_id', $anneeEncours->id)->sum("montant");
        $revenuMonthSum = Perception::paid()/*->whereBetween('created_at', [$monthFrom, $monthTo])*/ ->sum("montant");
        $rateRevenuMonth = $revenuTotalSum <= 0 ? 0 : intval($revenuMonthSum / $revenuTotalSum * 100);

        $depenseTotalSum = Depense::where('annee_id', $anneeEncours->id)->sum("montant");
        $depenseMonthSum = Depense::where('annee_id', $anneeEncours->id)->whereBetween('created_at', [$monthFrom, $monthTo])->sum("montant");
        $rateDepenseMonth = $depenseTotalSum <= 0 ? 0 : intval($depenseMonthSum / $depenseTotalSum * 100);

        $perceptionsRequest = Perception::where('annee_id', $anneeEncours->id);
        $perceptions = $perceptionsRequest->get();
        $perceptionsDues = $perceptionsRequest->sum("montant");
        $perceptionsPaid = $perceptionsRequest->sum("paid");
        $perceptionSold = $perceptionsDues - $perceptionsPaid;
        $ratePerceptionSold = $perceptionsDues <= 0 ? 0 : intval($perceptionSold / $perceptionsDues * 100);

        try {
            $taux = number_format(($perceptionsPaid / $perceptionsDues) * 100, 2);
        } catch (DivisionByZeroError) {
            $taux = null;
        }


        $this->revenuTotal = $revenuTotalSum;
        $this->depenseTotal = $depenseTotalSum;

        return view('livewire.dashboard.components.depenses-recettes-pie-chart');
    }
}
