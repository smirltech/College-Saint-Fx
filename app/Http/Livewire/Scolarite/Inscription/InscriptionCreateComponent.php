<?php

namespace App\Http\Livewire\Scolarite\Inscription;

use App\Enums\MinervalMonth;
use App\Enums\InscriptionStatus;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Perception;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Traits\CanHandleEleveUniqueCode;
use App\Traits\InscriptionUniqueCode;
use App\Traits\TopMenuPreview;
use App\Traits\WithFileUploads;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\URL;
use Illuminate\Support\HigherOrderCollectionProxy;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class InscriptionCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use WithFileUploads;
    use LivewireAlert;
    use CanHandleEleveUniqueCode;
    use InscriptionUniqueCode;


    public Collection $classes;

    public $has_paid = true;
    public Perception $perception;
    public Eleve $eleve;
    public Inscription $inscription;
    public ResponsableEleve $responsableEleve;

    public Collection $responsables;
    public ?string $section_id = null;
    /**
     * @var HigherOrderCollectionProxy|mixed
     */
    protected $listeners = ['onModalClosed'];
    protected $rules = [
        'eleve.nom' => 'required|string',
        'eleve.lieu_naissance' => 'nullable',
        'eleve.date_naissance' => 'nullable',
        'eleve.sexe' => 'nullable',
        'eleve.telephone' => 'nullable|string',
        'eleve.email' => 'nullable',
        'eleve.adresse' => 'nullable',
        'eleve.pere.nom' => 'nullable',
        'eleve.mere.nom' => 'nullable',
        'eleve.numero_permanent' => 'nullable',


        'responsableEleve.responsable_id' => 'nullable',
        'responsableEleve.relation' => 'nullable',

        'inscription.classe_id' => 'required|numeric|min:1|not_in:0',
        'inscription.categorie' => 'nullable',

        'perception.frais_id' => 'nullable',
        'perception.paid_by' => 'nullable',
        'perception.montant' => 'nullable',
    ];

    /**
     * @throws AuthorizationException
     */
    public function mount(Inscription $inscription): void
    {
        $this->authorize("create", Inscription::class);
        $this->inscription = $inscription;
        $this->eleve = $inscription->id ? $inscription->eleve : new Eleve();
        $this->perception = new Perception();
        $this->responsableEleve = new ResponsableEleve();
        $this->responsables = Responsable::orderBy('nom')->get();
        $this->classes = Classe::all();
    }

    public function submit(): void
    {
        $this->validate();

        $this->saveEleve();

        if ($this->responsableEleve->responsable_id) {
            $this->saveResponsableEleve();
        }

        $this->saveInscription();

        /* if ($this->has_paid)
             $this->savePerception();*/

        // Todo: uncomment block below to enable the printing of the inscription form
        /* $this->printIt();
         $this->alert('success', "Élève inscrit avec succès !");*/

        // Todo: Comment line below when the printing above is to be considered
        $this->flashSuccess('Élève enregistré avec succès', URL::previous());


        //  $this->alert('error', "L'enregistrement de l'étudiant n'a pas aboutis, veuillez reéssayer !");

    }

    public function saveEleve(): bool
    {
        return $this->eleve->fill([
            'section_id' => $this->section_id,
        ])->save();
    }

    private function saveResponsableEleve(): void
    {
        $this->responsableEleve->fill([
            'eleve_id' => $this->eleve->id,
        ])->save();
    }

    private function saveInscription(): bool
    {
        //  try {
        return $this->inscription->fill([
            'eleve_id' => $this->eleve->id,
            'annee_id' => Annee::id(),
            'status' => InscriptionStatus::approved->value,
        ])->save();
    }

    public function savePerception(): void
    {
        try {
            $this->perception->fill([
                    'user_id' => Auth::id(),
                    'inscription_id' => $this->inscription->id,
                    'custom_property' => MinervalMonth::annuel,
                    'annee_id' => Annee::id(),
                    'due_date' => Carbon::now()->format('Y-m-d'),
                    'paid' => true,
                ]
            );
        } catch (Exception $exception) {
            $this->error(local: $exception->getMessage(), production: "Echec d'imputation de frais déjà existante !");
        }
    }


    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.inscriptions.create')
            ->layout(AdminLayout::class, ['title' => $this->eleve->nom ?? 'Inscription Élève']);
    }

    public function updatedInscriptionClasseId(): void
    {
        $classe = Classe::find($this->inscription?->classe_id);
        $this->section_id = $classe?->section_id;
    }

}
