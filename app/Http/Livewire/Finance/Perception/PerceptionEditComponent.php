<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Frais;
use App\Models\Perception;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use URL;

class PerceptionEditComponent extends BaseComponent
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public $perception;
    public $annee_id;
    public $user_id;
    public $raisons = [];
    public $fee;

    public $eleveNom;
    public $classe_id;
    public $annee_nom;
    protected $rules = [
        'perception.inscription_id' => 'nullable',
        'perception.frais_id' => 'nullable',
        'perception.due_date' => 'nullable',
        'perception.montant' => 'required',
        'perception.paid' => 'nullable',
        'perception.paid_by' => 'nullable',
    ];
    private $annee;
    private $frais = [];
    private $inscriptions = [];
    private $inscription;

    public function mount(Perception $perception): void
    {
        $this->authorize('update', $perception);
        $this->user_id = Auth::id();
        $this->annee = Annee::encours();
        $this->annee_id = $this->annee->id;
        $this->annee_nom = $this->annee->nom;
        $this->perception = $perception;
        $this->frais = Frais::orderBy('nom')->get();


        $this->fee = $this->perception->frais;
    }

    public function updatedFeeId($value): void
    {
        $this->feeSelected($value);
    }

    public function feeSelected($value): void
    {
        $this->fee = Frais::find($value);
        $this->montant = $this->fee->montant ?? null;

    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.perceptions.edit',
            ['perception' => $this->perception, 'annee' => $this->annee, 'inscription' => $this->inscription, 'inscriptions' => $this->inscriptions, 'frais' => $this->frais])
            ->layout(AdminLayout::class, ['title' => 'Modifier Perception']);
    }


    public function editAndPrintPerception()
    {

        $this->editPerception();
    }

    public function editPerception(): void
    {

        try {
            $done = $this->doTheEdit();


            if ($done) {
                $this->flashSuccess("Facture modifiée avec succès !", URL::previous());

            } else {
                $this->alert('warning', "Echec de modification de facture !");
            }
        } catch (Exception $exception) {
            $this->error($exception->getMessage(), "Echec de modification de facture pour la fréquence déjà existante !");
        }
    }

    private function doTheEdit()
    {
        // dd($this->fee_id);
        // dd($this->perception);
        $this->validate([
            'perception.frais_id' => 'required',
            'perception.user_id' => 'required',
            'perception.due_date' => 'required',
            'perception.paid' => 'nullable',
            'perception.paid_by' => 'nullable',
        ]);

        return $this->perception->update(
            [
                'frais_id' => $this->perception->frais_id,
                'inscription_id' => $this->perception->inscription_id,
                'montant' => $this->perception->montant,
               // 'due_date' => $this->perception->due_date,
                // 'paid' => ($this->fee->type == FraisType::inscription and $this->paid == null) ? $this->montant : $this->paid,
                'paid_by' => $this->perception->paid_by,
            ]
        );

    }

    public function printIt()
    {
        /*  try {
              $this->doTheEdit();
          } catch (Exception $ex) {
              $this->error($ex->getMessage(), "Echec de modification de facture pour la fréquence déjà existante !");
          }
          $this->dispatchBrowserEvent('closeModal', ['modal' => 'recu-modal']);
          $this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => 301]);
      */
    }

    private function loadInscriptionFrais()
    {
        //$this->frais = Frais::where(['annee_id' => $this->annee_id, 'type' => FraisType::inscription])->orderBy('nom')->get();
    }
}
