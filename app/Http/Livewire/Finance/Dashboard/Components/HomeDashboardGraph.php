<?php

namespace App\Http\Livewire\Finance\Dashboard\Components;

use App\Models\Depense;
use App\Models\Paiment;
use App\Models\Perception;
use App\Models\Revenu;
use Carbon\Carbon;
use Livewire\Component;

class HomeDashboardGraph extends Component
{
    public $dayCount = 7;
    public $dateDebut;
    public $dateFin;


    // chart
    public array $dataset = [];
    public array $labels = [];

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($dayCount = 7)
    {

        $this->dayCount = $dayCount;
        $this->labels = $this->getLabels();

        $this->dataset = [
            [
                'label' => 'RA',
                'backgroundColor' => 'blue',
                'borderColor' => 'blue',
                'fill' => false,
                'lineTension' => 0.5,

                'data' => Revenu::dataOfLast(count($this->labels)),
            ],
            [
                'label' => 'Perceptions',
                'backgroundColor' => 'green',
                'borderColor' => 'green',
                'fill' => false,
                'lineTension' => 0.5,
                'data' => Perception::dataOfLast(count($this->labels)),
            ],
            [
                'label' => 'Dépenses',
                'backgroundColor' => 'red',
                'borderColor' => 'red',
                'fill' => false,
                'lineTension' => 0.5,
                'data' => Depense::dataOfLast(count($this->labels)),
            ],
            [
                'label' => 'Paiements',
                'backgroundColor' => 'orange',
                'borderColor' => 'orange',
                'fill' => false,
                'lineTension' => 0.5,
                'data' => Paiment::dataOfLast(count($this->labels)),
            ],

        ];
    }

    private function getLabels()
    {
        $this->dateFin = Carbon::now()->format('d M, Y');
        $this->dateDebut = Carbon::now()->subDays($this->dayCount)->format('d M, Y');
        $labels = [];
        for ($i = $this->dayCount - 1; $i >= 0; $i--) {
            $labels[] = Carbon::now()->subDays($i)->format('d-m');
        }
        return $labels;
    }

    public function render()
    {
        // $this->prepareData();
        return view('livewire.finance.dashboard.components.dashboard-graph', [
            "labels" => $this->labels,
            "dataset" => $this->dataset,
        ]);
    }
}
