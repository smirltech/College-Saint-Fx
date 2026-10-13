<?php

namespace App\Http\Livewire\Logistique\Fongible\Unit;

use App\Http\Livewire\BaseComponent;
use App\Models\Unit;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class UnitIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $units = [];
    public Unit $unit;

    protected $rules = [
        'unit.nom' => 'required|unique:units,nom',
        'unit.code' => 'required',
    ];

    public function mount()
    {
        $this->authorize("viewAny", Unit::class);
        $this->initUnit();
        $this->loadData();
    }

    public function initUnit()
    {
        $this->unit = new Unit();
    }

    public function loadData(): void
    {
        $this->units = Unit::orderBy('nom')->get();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->loadData();
        return view('livewire.logistiques.fongibles.units.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Units']);
    }


    public function addUnit(): void
    {
        $this->validate();

        try {
            $done = $this->unit->save();
            if ($done) {
                $this->onModalClosed('add-unit-modal');
                $this->loadData();
                $this->initUnit();
                $this->alert('success', "Unité ajoutée avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout de unité !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout d'unité, ce nom existe déjà !");
        }

    }


    public function getSelectedUnit(Unit $unit)
    {
        $this->unit = $unit;
    }

    public function updateUnit()
    {
        $this->validate([
            'unit.nom' => [
                "required",
                Rule::unique((new Unit())->getTable(), "nom")->ignore($this->unit->id)
            ],
            'unit.code' => 'required',
        ]);

        $done = $this->unit->save();
        if ($done) {
            $this->onModalClosed('update-unit-modal');
            $this->alert('success', "Unité modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification d'unité !");
        }

    }

    public function deleteUnit()
    {
        if ($this->unit->delete()) {
            $this->loadData();
            $this->alert('success', "Unité supprimée avec succès !");
        } else {
            $this->alert('warning', "Unité n'a pas été supprimée, il y a des éléments attachés !");
        }
        $this->onModalClosed('delete-unit-modal');

    }

}
