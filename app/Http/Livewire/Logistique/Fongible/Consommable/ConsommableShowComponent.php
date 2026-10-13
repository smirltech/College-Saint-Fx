<?php

namespace App\Http\Livewire\Logistique\Fongible\Consommable;

use App\Enums\MouvementStatus;
use App\Http\Livewire\BaseComponent;
use App\Models\Consommable;
use App\Models\Operation;
use App\Models\Unit;
use App\Models\User;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ConsommableShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public Consommable $consommable;
    public Operation $operation;
    public $users = [];
    public $units = [];

    protected $rules = [
        'consommable.unit_id' => 'required',
        'consommable.nom' => 'required',
        'consommable.code' => 'nullable',
        'consommable.description' => 'nullable',

        // Mouvement
        'operation.consommable_id' => 'nullable',
        'operation.user_id' => 'nullable',
        'operation.facilitateur_id' => 'nullable',
        'operation.beneficiaire' => 'nullable',
        'operation.date' => 'nullable',
        'operation.direction' => 'nullable',
        'operation.quantite' => 'nullable',
        'operation.observation' => 'nullable',
    ];

    public function mount(Consommable $consommable): void
    {
        $this->authorize("view", $consommable);
        $this->consommable = $consommable;
        // dd($this->materiel);
        $this->loadData();
        $this->initOperation();
    }

    public function loadData(): void
    {
        $this->units = Unit::orderBy('nom', 'ASC')->get();
        $this->users = User::orderBy('name', 'ASC')->get();
        // dd($this->users);
    }

    public function initOperation(): void
    {
        $this->operation = new Operation();
        $this->operation->date = Carbon::now()->format('Y-m-d');
        $this->operation->facilitateur_id = $this->users[0]->id;
        $this->operation->direction = MouvementStatus::in->name;
        $this->operation->quantite = null;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->loadData();
        return view('livewire.logistiques.fongibles.consommables.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur le consommable']);
    }

    public function updateConsommable()
    {
        $this->validate();

        $done = $this->consommable->save();
        if ($done) {
            $this->onModalClosed('update-consommable-modal');
            $this->alert('success', "Consommable modifié avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de consommable !");
        }
        $this->consommable->refresh();
    }


    public function getSelectedOperation(Operation $operation)
    {
        $this->operation = $operation;
    }


    // Mouvement du matériel
    public function addOperation()
    {
        $this->operation->consommable_id = $this->consommable->id;
        $this->operation->user_id = Auth::id();
        $this->validate([
            'operation.consommable_id' => 'required',
            'operation.user_id' => 'required',
            'operation.facilitateur_id' => 'required',
            'operation.beneficiaire' => 'nullable',
            'operation.quantite' => 'required',
            'operation.date' => 'required',
            'operation.direction' => 'required',
            'operation.observation' => 'nullable',
        ]);

        $done = $this->operation->save();
        if ($done) {
            $this->alert('success', $this->operation->direction->label() . " operation ajoutée avec succès !");
            $this->onModalClosed('add-operation-modal');
        } else {
            $this->alert('warning', "Échec d'ajout de " . $this->operation->direction->label() . " operation !");
        }

        $this->consommable->refresh();
    }

    public function updateOperation()
    {
        $this->validate();
        $done = $this->operation->save();
        if ($done) {
            $this->onModalClosed('update-operation-modal');
            $this->alert('success', "Operation modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification d'operation !");
        }
        $this->consommable->refresh();
    }

    public function deleteOperation()
    {
        if ($this->operation->delete()) {
            $this->loadData();
            $this->alert('success', "Operation supprimée avec succès !");
        } else {
            $this->alert('warning', "Échec de suppression d'operation !");
        }
        $this->onModalClosed('delete-operation-modal');
        $this->consommable->refresh();
    }

}
