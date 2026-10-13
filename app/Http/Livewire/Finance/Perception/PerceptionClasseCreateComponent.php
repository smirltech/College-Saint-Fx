<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Perception;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use URL;

class PerceptionClasseCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public $annee_id;
    public $user_id;
    public $raisons = [];
    public $fee_id;
    public $fee;
    public $montant;
    public $custom_property;
    public $eleveNbr = 0;
    public $classes = [];
    public $classe_id;
    public $due_date;
    protected $rules = [
        'classe_id' => 'required',
        'fee_id' => 'required',
        'due_date' => 'required',
        'montant' => 'required',
    ];
    private Classe|null $classe;
    private $frais = [];
    private $inscriptions = [];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize('create', Perception::class);
        $this->user_id = Auth::id();
        $this->annee_id = Annee::id();
        $this->due_date = Carbon::now()->format('Y-m-d');
        $this->frais = Frais::where('annee_id', $this->annee_id)->get();
        $this->classes = Classe::all();

    }

    public function updatedFeeId($value): void
    {
        $this->feeSelected();
    }

    public function feeSelected(): void
    {
        $this->fee = Frais::find($this->fee_id);
        $this->montant = $this->fee->montant ?? null;
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.finance.perceptions.classe_create',
            ['inscriptions' => $this->inscriptions, 'frais' => $this->frais])
            ->layout(AdminLayout::class, ['title' => 'Nouvelle Perception']);
    }

    public function updatedClasseId(): void
    {
        $this->changeClasse();
    }

    public function changeClasse(): void
    {
        $this->classe = Classe::find($this->classe_id);
        if ($this->classe) {
            $this->inscriptions = Inscription::where(['classe_id' => $this->classe_id, 'annee_id' => $this->annee_id])->get();
            $this->eleveNbr = $this->inscriptions->count();
        } else {
            $this->inscriptions = [];
            $this->eleveNbr = 0;
        }
        $this->fee_id = null;
        $this->fee = null;
        $this->montant = null;
    }

    public function addPerceptionsAndClose(): void
    {
        $this->addPerceptions();
        $this->flash('success', "Classe facturée avec succès !", [], route('finance.perceptions'));

    }

    public function addPerceptions(): void
    {
        $this->validate();

        $this->inscriptions = Inscription::where(['classe_id' => $this->classe_id, 'annee_id' => $this->annee_id])->get();
        $this->inscriptions->each(fn($inscription) => $this->addPerceptionForInscription($inscription));

        $this->flashSuccess("Classe facturée avec succès !", URL::previous());
    }

    private function addPerceptionForInscription(Inscription $inscription): void
    {
        try {
            Perception::updateOrCreate(
                [
                    'frais_id' => $this->fee_id,
                    'inscription_id' => $inscription->id,
                    'annee_id' => $this->annee_id,
                    'due_date' => $this->due_date,
                ], [
                    'user_id' => $this->user_id,
                    'frais_id' => $this->fee_id,
                    'inscription_id' => $inscription->id,
                    'annee_id' => $this->annee_id,
                    'montant' => $this->montant,
                    'due_date' => $this->due_date,
                ]
            );
        } catch (Exception $exception) {
            $this->error(local: $exception->getMessage());
        }
    }

}
