<?php

namespace App\Http\Livewire\Scolarite\Filiere;

use App\Http\Livewire\BaseComponent;
use App\Models\Option;
use App\Models\Section;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FiliereIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $options = [];
    public $sections = [];


    public $nom;
    public $description;
    public $code;
    public $option_id;
    public $section_id;

    public $filieres = [];

    protected $rules = [
        'nom' => 'required|unique:filieres',
        'code' => 'required|unique:filieres',
        'description' => 'nullable',
        'option_id' => 'required',

    ];

    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];

    protected $listeners = ['onSaved', 'onUpdated', 'onDeleted', 'onModalOpened', 'onModalClosed'];

    public function onModalOpened(): void
    {
        $this->clearValidation();
    }

    public function onSaved(): void
    {
        $this->loadData();
    }

    public function loadData(): void
    {
        $this->filieres = Option::orderBy('nom', 'ASC')->get();
    }

    public function onUpdated(): void
    {
        $this->loadData();
    }

    public function onDeleted(): void
    {
        $this->loadData();
    }

    public function mount(): void
    {
        $this->options = [];
        $this->sections = Section::orderBy('nom')->get();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->loadData();

        return view('livewire.scolarite.filieres.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Filières']);
    }

    // updated section_id
    public function updatedSectionId(): void
    {
        $this->changeSection();
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

    public function addFiliere()
    {
        // dd($this->nom);

        $this->validate();
        Option::create([
            'nom' => $this->nom,
            'description' => $this->description,
            'code' => $this->code,
            'option_id' => $this->option_id,

        ]);
        $this->emit('onSaved');
        $this->alert('success', "Filière ajoutée avec succès !");

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-filiere-modal']);
        $this->onModalClosed();
    }


    public function getSelectedFiliere(Option $filiere)
    {
        // dd($section);
        $this->filiere = $filiere;
        $this->nom = $filiere->nom;
        $this->code = $filiere->code;
        $this->description = $filiere->description;
        $this->option_id = $filiere->option_id;
        $this->section_id = $filiere->option->section_id;
        $this->options = Option::where('section_id', $this->section_id)->orderBy('nom')->get();
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

    public function deleteFiliere()
    {
        if (count($this->filiere->classes) == 0) {
            if ($this->filiere->delete()) {
                $this->loadData();
                $this->alert('success', "Filière supprimée avec succès !");
                $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-filiere-modal']);
            }
        } else {
            $this->alert('warning', "Filière n'a pas été supprimée, il y a des classes attachées !");
        }
        $this->onModalClosed();

    }

}
