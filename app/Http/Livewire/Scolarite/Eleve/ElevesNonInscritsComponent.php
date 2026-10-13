<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Enums\MinervalMonth;
use App\Enums\FraisType;
use App\Enums\InscriptionCategorie;
use App\Enums\InscriptionStatus;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Eleve;
use App\Models\Option;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Perception;
use App\Models\Section;
use App\Traits\FakeProfileImage;
use App\Traits\InscriptionUniqueCode;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Exception;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ElevesNonInscritsComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;
    use FakeProfileImage;
    use InscriptionUniqueCode;


    public $options = [];
    public $sections = [];
    public $filieres = [];
    public $classes = [];

    //inscription
    public $section_id;
    public $option_id;
    public $filiere_id;
    public $classe_id;

    public $eleves = [];
    public ?Eleve $eleve = null;

    public $fee;
    public $paid_by;
    public $categorie;

    protected $rules = [
        'classe_id' => 'required|numeric|min:1|not_in:0',
        'filiere_id' => 'nullable|numeric|min:1|not_in:0',
        'option_id' => 'nullable|numeric|min:1|not_in:0',
        'section_id' => 'required|numeric|min:1|not_in:0',

        'categorie' => 'required|string',
        'fee.id' => 'nullable',
        'fee.montant' => 'nullable',
    ];
    protected $messages = [
        'section_id.required' => 'La section est obligatoire !',
        'classe_id.required' => 'La classe est obligatoire !',
        'categorie.required' => 'La categorie est obligatoire !',
    ];

    public function mount()
    {
        $this->authorize("viewAny", Eleve::class);
        $this->loadData();
    }

    public function loadData()
    {
        $this->sections = Section::orderBy('nom')->get();
        $this->eleves = Eleve::nonInscritsAnneeEnCours();
        $this->categorie = InscriptionCategorie::normal->name;
        $this->setFakeProfileImageUrl();
    }

    public function render()
    {

        return view('livewire.scolarite.eleves.non_inscrits', [
            'eleves' => $this->eleves
        ])
            ->layout(AdminLayout::class, ['title' => "Liste d'élèves non inscrits"]);
    }

    public function getSelectedEleve($eleve_id)
    {
        $this->eleve = Eleve::find($eleve_id);
        //dd($this->eleve);
    }

    // Handling section changes
    public function changeSection()
    {
        $this->options = [];
        $this->filieres = [];
        if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->options = $section?->options ?? [];
        }

        $this->option_id = null;
        $this->filiere_id = null;
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }

    private function loadAvailableClasses()
    {
        if ($this->filiere_id > 0) {
            $filiere = Option::find($this->filiere_id);
            $this->classes = $filiere?->classes ?? [];
        } else if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $this->classes = $option?->classes ?? [];
        } else if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->classes = $section?->classes ?? [];
        }
        $this->getAvailableFrais();
    }

    private function getAvailableFrais()
    {
        $ff = null;
        if ($this->classe_id != null) {
            $ff = Frais::
            where('annee_id', Annee::id())
                ->where('type', FraisType::INSCRIPTION)
                ->where('classable_type', 'like', '%Classe')
                ->where('classable_id', $this->classe_id)
                ->orderBy('nom')
                ->first();
        }
        if ($ff == null && $this->filiere_id != null) {
            $ff = Frais::
            where('annee_id', Annee::id())
                ->where('type', FraisType::INSCRIPTION)
                ->where('classable_type', 'like', '%Option')
                ->where('classable_id', $this->filiere_id)
                ->orderBy('nom')
                ->first();
        }
        if ($ff == null && $this->option_id != null) {
            $ff = Frais::
            where('annee_id', Annee::id())
                ->where('type', FraisType::INSCRIPTION)
                ->where('classable_type', 'like', '%Option')
                ->where('classable_id', $this->option_id)
                ->orderBy('nom')
                ->first();
        }
        if ($ff == null && $this->section_id != null) {
            $ff = Frais::
            where('annee_id', Annee::id())
                ->where('type', FraisType::INSCRIPTION)
                ->where('classable_type', 'like', '%Section')
                ->where('classable_id', $this->section_id)
                ->orderBy('nom')
                ->first();
        }
        $this->fee = $ff;
    }

    public function changeOption()
    {
        $this->filieres = [];
        if ($this->option_id > 0) {
            $option = Option::find($this->option_id);
            $this->filieres = $option?->filieres ?? [];
        }
        $this->filiere_id = null;
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }

    public function changeFiliere()
    {
        $this->classe_id = null;
        $this->loadAvailableClasses();
    }

    public function changeClasse()
    {
        $this->loadAvailableClasses();
    }


    // Do the inscription

    public function addReinscription()
    {
        $this->submitInscription();
    }

    private function submitInscription()
    {
        $inscription = Inscription::create([
            'eleve_id' => $this->eleve->id,
            'classe_id' => $this->classe_id,
            'annee_id' => Annee::id(),
            'categorie' => $this->categorie,
            'montant' => $this->fee->montant,
            'status' => InscriptionStatus::approved->value,
        ]);

        if ($inscription) {
            $this->addPerception($inscription->id);
            $this->onModalClosed('reinscription-modal');
            $this->loadData();
            $this->alert('success', "Élève réinscrit avec succès !");
        } else {
            $this->alert('warning', "Échec de réinscription de l'élève !");
        }
    }

    private function addPerception($inscription_id)
    {

        $this->validate([
            'fee.id' => 'required',
            'fee.montant' => 'required',
            'paid_by' => 'nullable',
        ]);

        try {
            $done = Perception::create(
                [
                    'user_id' => Auth::id(),
                    'frais_id' => $this->fee->id,
                    'inscription_id' => $inscription_id,
                    'frequence' => MinervalMonth::annuel->name,
                    'custom_property' => MinervalMonth::annuel,
                    'annee_id' => Annee::id(),
                    'montant' => $this->fee->montant,
                    'due_date' => Carbon::now()->format('Y-m-d'),
                    'frais_montant' => $this->fee->montant,
                    //'paid' => ($this->fee->type == FraisType::inscription and $this->paid == null) ? $this->montant : $this->paid,
                    'paid_by' => $this->paid_by,
                ]
            );

            // $this->flash('success', "Frais imputé avec succès !", [], route('finance.perceptions'));

        } catch (Exception $exception) {
            $this->error(local: $exception->getMessage(), production: "Echec d'imputation de frais déjà existante !");
        }

    }


}
