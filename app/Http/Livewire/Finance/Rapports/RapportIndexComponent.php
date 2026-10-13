<?php

namespace App\Http\Livewire\Finance\Rapports;


use App\Models\Annee;
use App\Models\Depense;
use App\Models\Frais;
use App\Models\Perception;
use App\Models\Revenu;
use App\Traits\TopMenuPreview;

use App\Traits\WithPrintToPdf;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RapportIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;
    use WithPrintToPdf;

    public $date_from;
    public $date_to;

    public $revenuAuxiliaire = 0;
    public $perception = 0;
    public $frais = [];
    public $depenses = 0;
    public $depensesTypes = [];
    public $annee_id;
    public $anneeNom;
    protected $rules = [
        'date_from' => 'nullable',
        'date_to' => 'nullable',
    ];
    private $annee;

    public function mount()
    {
        $this->annee = Annee::encours();
        $this->annee_id = $this->annee->id;
        $this->anneeNom = $this->annee->nom;
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->format('Y-m-d');

    }


    public function render()
    {
        $this->loadData();
        return view('livewire.finance.rapports.index', ['annee' => $this->annee,'title' => $this->title])
            ->layout(AdminLayout::class, ['title' => $this->title]);
    }


    public function  getTitleProperty(): string
    {
        return 'Rapport financier du ' . now()->parse($this->date_from)->format('d-m-Y') . ' au ' . now()->parse($this->date_to)->format('d-m-Y');

    }
    public function loadData(): void
    {
        $this->revenuAuxiliaire = Revenu::sommeBetween(annee_id: $this->annee_id, ddebut: $this->date_from, dfin: $this->date_to);
        $this->perception = Perception::sommeBetween(annee_id: $this->annee_id, ddebut: $this->date_from, dfin: $this->date_to);
        $this->frais = Frais::sommeFraisByTypeBetween(annee_id: $this->annee_id, ddebut: $this->date_from, dfin: $this->date_to);

        $this->depenses = Depense::sommeBetween(annee_id: $this->annee_id, ddebut: $this->date_from, dfin: $this->date_to);
        $this->depensesTypes = Depense::sommeDepensesByTypeBetween(annee_id: $this->annee_id, ddebut: $this->date_from, dfin: $this->date_to);
    }

    public function updateReport()
    {

    }

    public function printIt(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        //$this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => '100%']);

        return $this->printToPdf('livewire.finance.rapports.modals.printable', $this->all(), $this->title.'.pdf');

    }
}
