<?php

namespace App\Http\Livewire\Scolarite\Resultat\Block;

use App\Enums\MediaType;
use App\Enums\ResultatType;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Inscription;
use App\Models\Resultat;
use App\Traits\CanDeleteMedia;
use App\Traits\HasLivewireAlert;
use App\Traits\WithFileUploads;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithPagination;

class ResultatsBlockComponent extends Component
{
    use HasLivewireAlert, WithPagination, WithFileUploads, CanDeleteMedia;


    public Classe $classe;
    public $inscriptions = [];
    //public $resultats = [];
    public Resultat $resultat;
    public Inscription $inscription;
    public ResultatType $resultatType;
    public $resultatTypeValue;
    public TemporaryUploadedFile|string|null $bulletin = null;

    protected $rules = [
        'resultat.pourcentage' => 'required',
        'resultat.place' => 'required',
        'resultat.conduite' => 'nullable',
    ];

    protected $listeners = ['onModalClosed'];

    public function mount(Classe $classe)
    {
        $this->resultatTypeValue = ResultatType::p1->value;
        //$this->resultatType = ResultatType::p1;
        $this->selectResultatType();
        $this->classe = $classe;
        $this->initResultat();
        $this->initInscription();
        // $this->loadData();

    }

    public function selectResultatType(): void
    {
        $this->resultatType = ResultatType::from($this->resultatTypeValue);
        //  $this->loadData();
    }

    private function initResultat(): void
    {
        $this->resultat = new Resultat();
        $this->resultat->annee_id = Annee::id();
        $this->resultat->classe_id = $this->classe->id;
        //if($this->re)

    }

    private function initInscription(): void
    {
        $this->inscription = new Inscription();
    }

    public function selectInscription($id): void
    {
        $this->inscription = Inscription::find($id);
        $temp = $this->inscription->resultats()->where('custom_property', $this->resultatType)->first();
        if ($temp != null) {
            $this->resultat = $temp;
        } else {
            $this->initResultat();
        }
        //  $this->loadData();
    }

    public function render(): Factory|View|Application
    {
        $this->loadData();
        return view('livewire.scolarite.resultats.blocks.list');
    }

    public function loadData(): void
    {
        $this->inscriptions = $this->classe->inscriptionsAsOfPlaceOfResultats($this->resultatType);
    }

    public function updateResultat(): void
    {
        $this->validate();
        $this->resultat->custom_property = $this->resultatType->value;
        $this->resultat->annee_id = Annee::id();
        $this->resultat->classe_id = $this->classe->id;
        $this->resultat->inscription_id = $this->inscription->id;
        //$this->resultat->conduite = Conduite::b->name;

        try {
            $this->resultat = Resultat::updateOrCreate(
                [
                    'inscription_id' => $this->resultat->inscription_id,
                    'classe_id' => $this->resultat->classe_id,
                    'annee_id' => $this->resultat->annee_id,
                    'custom_property' => $this->resultat->custom_property,
                ],
                [
                    'pourcentage' => $this->resultat->pourcentage,
                    'place' => $this->resultat->place,
                    'conduite' => $this->resultat->conduite,
                ]
            );
            if ($this->bulletin) {
                $this->resultat->addMedia(file: $this->bulletin, collection_name: MediaType::document->value);
                $this->bulletin = null;
            }
            $this->onModalClosing('update-resultat');
            $this->alert('success', "Résultat modifié avec succès !");
        } catch (Exception $e) {
            $this->error(local: $e->getMessage(), production: "Une erreur s'est produite lors de la modification du résultat !");
        }

    }

    public function onModalClosing($modalId): void
    {
        $this->dispatchBrowserEvent('closeModal', ['modal' => $modalId]);
        $this->initResultat();
        $this->initInscription();
        $this->loadData();

        //$this->reset(['nom', 'description', 'montant', 'classable_type', 'classable_id']);
    }

    public function printIt(): void
    {
        $this->loadData();
        $this->dispatchBrowserEvent('printIt', ['elementId' => "resultatsPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }

    private function refreshData(): void
    {
        $this->resultat->refresh();
    }
}
