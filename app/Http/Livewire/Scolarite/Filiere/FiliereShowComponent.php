<?php

namespace App\Http\Livewire\Scolarite\Filiere;

use App\Http\Livewire\BaseComponent;
use App\Models\Classe;
use App\Models\Option;
use App\Models\Section;
use App\Traits\FiliereCode;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FiliereShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;
    use FiliereCode;

    public $options = [];
    public $sections = [];

    public $nom;
    public $description;
    public $code;
    public $option_id;
    public $section_id;

    public $filiere;

    public $classe_niveau;
    public $classe_code;

    protected $rules = [
        'nom' => 'required|unique:filieres',
        'code' => 'required|unique:filieres',
        'description' => 'nullable',
        'option_id' => 'required|numeric',

    ];

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'option_id.required' => 'L\'option est obligatoire !',
    ];

    protected $listeners = ['onSaved', 'onUpdated', 'onDeleted', 'onModalOpened', 'onModalClosed'];

    public function onModalOpened()
    {
        $this->clearValidation();
    }

    public function onSaved()
    {
        $this->loadData();
    }

    // updated classe_niveau

    public function loadData()
    {
        //  $this->filieres = Option::/* orderBy('encours', 'DESC')-> */ orderBy('nom', 'ASC')->get();
    }

    public function updatedClasseNiveau()
    {
        $this->setCode();
    }

    public function onUpdated()
    {
        $this->loadData();
    }

    public function onDeleted()
    {
        $this->loadData();
    }

    public function mount(Option $filiere)
    {
        $this->authorize("view", $filiere);
        $this->sections = Section::orderBy('nom')->get();

        $this->filiere = $filiere;
        $this->nom = $filiere->nom;
        $this->code = $filiere->code;
        $this->description = $filiere->description;
        $this->option_id = $filiere->option_id;
        $this->section_id = $filiere->option->section_id;
        $this->options = Option::where('section_id', $this->section_id)->orderBy('nom')->get();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.scolarite.filieres.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la filière']);
    }

    public function changeSection(): void
    {
        if ($this->section_id > 0) {
            $section = Section::find($this->section_id);
            $this->options = $section->options;
            if (count($this->options) > 0) {
                $option = $this->options[0];
                $this->option_id = $option->id;

            } else {
                $this->option_id = null;
                $this->options = [];
            }
        } else {
            $this->option_id = null;
            $this->options = [];
        }
    }

    public function updateFiliere()
    {
        $this->validate([
            'nom' => [
                "required",
                Rule::unique((new Option())->getTable(), "nom")->ignore($this->filiere->id)

            ],
            'code' => [
                "required",
                Rule::unique((new Option)->getTable(), "code")->ignore($this->filiere->id)

            ],
            'option_id' => 'required|numeric',
            'description' => 'nullable',
        ]);

        $done = $this->filiere->update([
            'nom' => $this->nom,
            'code' => $this->code,
            'description' => $this->description,
            'option_id' => $this->option_id,
        ]);
        if ($done) {
            $this->emit('onUpdated');
            $this->alert('success', "Filière modifiée avec succès !");

            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-filiere-modal']);
            //$this->flash('success', 'Section modifiée avec succès', [], route('scolarite.sections'));
        } else {
            $this->alert('warning', "Echec de modification de filière !");
        }
        $this->onModalClosed();

    }


    public function addClasse()
    {
        $this->validate([
            'classe_grade' => "required",
            'classe_code' => [
                "required",
                Rule::unique((new Classe())->getTable(), "code")
            ],

        ]);

        $classe = new Classe();
        $classe->niveau = $this->classe_grade;
        $classe->code = $this->classe_code;

        $this->filiere->classes()->save($classe);

        $this->emit('onSaved');
        $this->alert('success', "Classe ajoutée avec succès !");

        //$this->reset(['filiere_nom', 'filiere_code']);

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-classe-modal']);
        $this->onModalClosed();
    }

}
