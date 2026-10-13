<?php

namespace App\Http\Livewire\Finance\Depenses;

use App\Enums\Devise;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Depense;
use App\Models\DepenseType;
use App\Models\Frais;
use App\Models\Perception;
use App\Models\Revenu;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DepenseIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $annee_id;
    public $depenses = [];
    public $depense;

    public $types = [];
    public $type;

    public $montant;
    public $note;
    public $reference;
    protected $rules = [
        'type.id' => 'required',
    ];

    protected $messages = [
        'montant.required' => 'Le montant est obligatoire !',
        'nom.required' => 'Le nom est obligatoire !',
        'type.id.required' => 'La type est obligatoire !',
    ];

    protected $listeners = ['onModalClosed'];

    public function mount(): void
    {
        $this->authorize('viewAny', Depense::class);
        $this->annee_id = Annee::id();
        $this->types = DepenseType::orderBy('nom')->get();
        $this->type = $this->types[0] ?? new DepenseType();

        $this->type_id = request()->get('type_id') ?: '';

    }

    public function render()
    {
        $this->loadData();
        return view('livewire.finance.depenses.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Dépenses']);
    }

    public function getPerceptionsProperty(): Collection
    {
        $perceptionsRequest = Perception::when($this->classe_id, function ($q) {
            $q->whereHas('inscription', function ($q) {
                $q->where('classe_id', $this->classe_id);
            });
        })->when($this->frais_id, function ($q) {
            $q->where('frais_id', $this->frais_id);
        });

        return $this->perceptions = $perceptionsRequest->latest()->limit(1000)->get();
    }

    public function getBoxesProperty(): array
    {

        $depensesQuery = Depense::query();


        $perceptionsUSD = Perception::usd()->sum('montant');
        $perceptionsCDF = Perception::cdf()->sum('montant');


        $depensesUSD = $depensesQuery->clone()->usd()->sum('montant');
        $depensesCDF = $depensesQuery->clone()->cdf()->sum('montant');

        $revenueUSD = Revenu::usd()->sum('montant');
        $revenueCDF = Revenu::cdf()->sum('montant');

        $soldeUSD = number_format(($perceptionsUSD + $revenueUSD) - $depensesUSD);
        $soldeCDF = number_format(($perceptionsCDF + $revenueCDF) - $depensesCDF);

        return [
            [
                'title' => "{$perceptionsCDF}Fc / {$perceptionsUSD}$",
                'text' => 'Perceptions',
                'icon' => 'fas fa-coins',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
            [
                'title' => "{$depensesCDF}Fc / {$depensesUSD}$",
                'text' => 'Depenses',
                'icon' => 'fas fa-credit-card',
                'theme' => 'gradient-danger',
                'url' => '#'

            ],
            [
                'title' => "{$soldeCDF}Fc / {$soldeUSD}$",
                'text' => "Solde",
                'icon' => 'fas fa-user',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
        ];
    }

    public function loadData()
    {
        $this->types = DepenseType::orderBy('nom')->get();
        $this->depenses = Depense::orderBy('created_at', 'DESC')->take(100 )->get();
    }

}
