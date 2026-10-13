<?php

namespace App\Http\Livewire\Finance\DepenseType;

use App\Http\Livewire\BaseComponent;
use App\Models\DepenseType;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class DepenseTypeIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $depenseTypes = [];
    public $depenseType;
    protected $rules = [
        'depenseType.nom' => 'required',
        'depenseType.description' => 'nullable',
    ];
    protected $messages = [
        'depenseType.nom.required' => 'Ce nom est obligatoire !',
    ];

    public function mount()
    {
        $this->authorize('viewAny', DepenseType::class);
        $this->depenseType = new DepenseType();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.finance.depenses_types.index')
            ->layout(AdminLayout::class);
    }

    public function loadData()
    {
        $this->depenseTypes = DepenseType::orderBy('nom')->get();
    }

    public function addTypeDepense()
    {
        // dd($this->nom);

        $this->validate([
            'depenseType.nom' => 'required|unique:depense_types,nom',
            'depenseType.description' => 'nullable',
        ]);

        //dd($this->depenseType);
        $this->depenseType->save();
        $this->onModalClosed('add-type-modal');
        $this->alert('success', "Dépense Type ajoutée avec succès !");
    }


    public function getSelectedTypeDepense(DepenseType $depenseType)
    {
        $this->depenseType = $depenseType;
    }

    public function updateTypeDepense()
    {
        $this->validate([
            'depenseType.nom' => [
                "required",
                Rule::unique((new DepenseType())->getTable(), "nom")->ignore($this->depenseType->id)

            ],

            'depenseType.description' => 'nullable',
        ]);

        $done = $this->depenseType->update();
        if ($done) {
            $this->alert('success', "Dépense Type modifiée avec succès !");
        } else {
            $this->alert('warning', "Echec de modification de Dépense Type !");
        }
        $this->onModalClosed('edit-type-modal');

    }

    public function deleteTypeDepense()
    {
        if (count($this->depenseType->depenses) == 0) {
            if ($this->depenseType->delete()) {
                $this->loadData();
                $this->alert('success', "Dépense Type supprimée avec succès !");
            }
        } else {
            $this->alert('warning', "Dépense Type n'a pas été supprimée, il y a des Dépenses attachées !");
        }
        $this->onModalClosed('delete-type-modal');

    }
}
