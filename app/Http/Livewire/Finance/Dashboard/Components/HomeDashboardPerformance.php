<?php

namespace App\Http\Livewire\Finance\Dashboard\Components;


use App\Enums\FraisType;
use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Models\Annee;
use App\Models\Frais;
use Faker\Factory;
use Livewire\Component;
use Pharaonic\Laravel\Readable\Readable;

class HomeDashboardPerformance extends Component
{
    public $annee_id;
    public $dayCount = 7;
    public $dateDebut;
    public $dateFin;
    public array $frais = [];


    // chart
    public $fullFrais;
    private $faker;

    /**
     * Create a new component instance.
     *
     * @return void
     */
    public function mount($dayCount = 7)
    {

        $this->faker = Factory::create();

        $this->dayCount = $dayCount;
        $this->annee_id = Annee::encours()->id;

        $this->fullFrais = Frais::where('annee_id', $this->annee_id)->get();
        $this->prepareData();
    }

    private function prepareData()
    {
        $this->faker = Factory::create();
        $this->frais = [];
        foreach (FraisType::cases() as $ft) {
            $t = Frais::montantFraisTypeOf($this->annee_id, $ft, $this->dayCount);
            $m = Frais::paidFraisTypeOf($this->annee_id, $ft, $this->dayCount);

            $p = $t == 0 ? $m / 1 * 100 : $m / $t * 100;
            $this->frais[] =
                [
                    'name' => $ft->label(),
                    'montant' => Readable::getHumanNumber($m, showDecimal: true, decimals: 2),
                    'total' => Readable::getHumanNumber($t, showDecimal: true, decimals: 2),
                    'rate' => $p,
                    'color' => $this->faker->unique()->safeColorName(),
                ];
        }

    }

    public function render()
    {
        return view('livewire.finance.dashboard.components.home-performance');
    }
}

