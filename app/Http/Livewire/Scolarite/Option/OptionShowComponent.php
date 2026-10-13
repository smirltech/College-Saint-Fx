<?php

namespace App\Http\Livewire\Scolarite\Option;

use App\Http\Livewire\BaseComponent;
use App\Models\Option;
use App\Models\Section;
use App\Traits\OptionCode;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class OptionShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;
    use OptionCode;

    public $nom;
    public $code;

    public $filiere_nom;
    public $filiere_code;

    public $sections = [];

    public $option;

    public $classes = [];
    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',

        'filiere_nom.required' => 'Ce nom est obligatoire !',
        'filiere_nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'filiere_code.required' => 'Ce code est obligatoire !',
        'filiere_code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];
    protected $listeners = ['onSaved', 'onUpdated', 'onDeleted', 'onModalOpened', 'onModalClosed'];

    public function mount(Option $option)
    {
        $this->authorize("view", $option);
        $this->option = $option;
        $this->nom = $option->nom;
        $this->code = $option->code;

        $this->sections = Section::orderBy('nom')->get();
        $this->classes = $this->option->classes;
    }

    public function onModalOpened()
    {
        $this->clearValidation();
    }

    public function onSaved()
    {
        $this->loadData();
    }

    public function loadData()
    {
        //  $this->options = Option::orderBy('nom', 'ASC')->get();
        $this->classes = $this->option->classes;
    }

    public function onUpdated()
    {
        $this->loadData();
    }

    public function onDeleted()
    {
        $this->loadData();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.options.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur l\'option']);
    }

    public function updateOption()
    {
        $this->validate([
            'nom' => [
                "required",
                Rule::unique((new Option)->getTable(), "nom")->ignore($this->option->id)

            ],
            'code' => [
                "required",
                Rule::unique((new Option)->getTable(), "code")->ignore($this->option->id)

            ],
            'section_id' => 'required|numeric',
        ]);

        $done = $this->option->update([
            'nom' => $this->nom,
            'code' => $this->code,
            'section_id' => $this->section_id,
        ]);
        if ($done) {
            $this->emit('onUpdated');
            $this->alert('success', "Option modifiée avec succès !");

            $this->reset(['nom', 'code', 'section_id']);

            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-option-modal']);
            //$this->flash('success', 'Section modifiée avec succès', [], route('scolarite.sections'));
        } else {
            $this->alert('warning', "Echec de modification d'option !");
        }
        $this->onModalClosed();

    }


    // ---------------------------

    public function addFiliere()
    {
        // dd($this->nom);

        $this->validate([
            'filiere_nom' => [
                "required",
                Rule::unique((new Option())->getTable(), "nom")

            ],
            'filiere_code' => [
                "required",
                Rule::unique((new Option())->getTable(), "code")

            ],

        ]);

        Option::create([
            'nom' => $this->filiere_nom,
            'code' => $this->filiere_code,
            'option_id' => $this->option->id,
        ]);
        $this->emit('onSaved');
        $this->alert('success', "Filière ajoutée avec succès !");

        $this->reset(['filiere_nom', 'filiere_code']);

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-filiere-modal']);
        $this->onModalClosed();
    }
}
