<?php

namespace App\Http\Livewire\Finance\Revenu;

use App\Http\Integrations\Scolarite\Requests\Annee\GetCurrentAnnneRequest;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Revenu;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RevenuIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $revenus = [];
    public $revenu;
    public $nom;
    public $montant;
    public $description;

    public $annee_id;

    protected $messages = [
        'montant.required' => 'Le montant est obligatoire !',
        'nom.required' => 'Le nom est obligatoire !',
    ];

    protected $listeners = ['onModalClosed'];

    public function mount(): void
    {
        $this->authorize('viewAny', Revenu::class);
        $this->annee_id = Annee::id();

    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->loadData();
        return view('livewire.finance.revenus.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Revenus']);
    }

    public function loadData(): void
    {
        // todo: we should consider annee_id when fetching data
        $this->revenus = Revenu::orderBy('created_at', 'DESC')->get();
    }

    public function addRevenu(): void
    {
        // dd($this->nom);

        $this->validate([
            'montant' => 'required',
            'nom' => 'required',
            'description' => 'nullable',
            'annee_id' => 'required',
        ]);

        Revenu::create([
            'nom' => $this->nom,
            'montant' => $this->montant,
            'description' => $this->description,
            'annee_id' => $this->annee_id,
        ]);

        $this->alert('success', "Revenu ajouté avec succès !");

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-revenu-modal']);
        $this->onModalClosed();
    }


    public function getSelectedRevenu(Revenu $revenu): void
    {
        $this->revenu = $revenu;
        $this->nom = $revenu->nom;
        $this->montant = $revenu->montant;
        $this->description = $revenu->description;
    }

    public function updateRevenu(): void
    {
        $this->validate([
            'montant' => "required",
            'nom' => "required",
            'description' => 'nullable',
        ]);

        $done = $this->revenu->update([
            'nom' => $this->nom,
            'montant' => $this->montant,
            'description' => $this->description,
        ]);
        if ($done) {
            $this->alert('success', "Revenu modifié avec succès !");

            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-revenu-modal']);
        } else {
            $this->alert('warning', "Echec de modification de revenu !");
        }
        $this->onModalClosed();

    }

    public function deleteRevenu(): void
    {

        if ($this->revenu->delete()) {
            $this->loadData();
            $this->alert('success', "Revenu supprimé avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-revenu-modal']);
        }

        $this->onModalClosed();

    }

}
