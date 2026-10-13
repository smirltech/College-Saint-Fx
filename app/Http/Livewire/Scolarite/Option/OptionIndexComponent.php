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

class OptionIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;
    use OptionCode;

    public $nom;
    public $code;
    public $section_id;

    public $sections = [];
    public $options = [];
    public $option;
    protected $messages = [
        'nom.required' => 'Ce nom est obligatoire !',
        'nom.unique' => 'Ce nom est déjà pris, cherchez-en un autre !',

        'code.required' => 'Ce code est obligatoire !',
        'code.unique' => 'Ce code est déjà pris, cherchez-en un autre !',
    ];
    protected $listeners = ['onSaved', 'onUpdated', 'onDeleted', 'onModalOpened', 'onModalClosed'];

    public function mount()
    {
        $this->authorize("viewAny", Option::class);
        if (request()->has('section_id')) {
            $this->section_id = request()->section_id;
        }
        $this->sections = Section::orderBy('nom')->get();
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
        $this->options = Option::orderBy('nom', 'ASC')->get();
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
        return view('livewire.scolarite.options.index')
            ->layout(AdminLayout::class, ['title' => 'Liste d\'options']);
    }

    public function addOption()
    {
        // dd($this->nom);

        $this->validate([
            'nom' => 'required|unique:options',
            'code' => 'required|unique:options',
            'section_id' => 'required|numeric',
        ]);

        Option::create([
            'nom' => $this->nom,
            'code' => $this->code,
            'section_id' => $this->section_id,
        ]);
        $this->emit('onSaved');
        $this->alert('success', "Section ajoutée avec succès !");

        $this->reset(['nom', 'code']);

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-option-modal']);
        $this->onModalClosed();
    }


    public function getSelectedOption(Option $option)
    {
        // dd($section);
        $this->option = $option;
        $this->nom = $option->nom;
        $this->code = $option->code;
        $this->section_id = $option->section_id;
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

    public function deleteOption()
    {
        if (count($this->option->filieres) == 0) {
            if ($this->option->delete()) {
                $this->loadData();
                $this->alert('success', "Option supprimée avec succès !");
                $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-option-modal']);
            }
        } else {
            $this->alert('warning', "Option n'a pas été supprimée, il y a des filières attachées !");
        }
        $this->onModalClosed();

    }


    /* public function deleteOption($id)
     {
         $option = Option::find($id);
         if (count($option->filieres) == 0) {
             if ($option->delete()) {
                 $this->loadData();
                 $this->alert('success', "Option supprimée avec succès !");
             }
         } else {
             $this->alert('warning', "Section n'a pas été supprimée, il y a des filières attachées !");
         }
     }*/
}
