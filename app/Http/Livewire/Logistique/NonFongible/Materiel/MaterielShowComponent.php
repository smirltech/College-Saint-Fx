<?php

namespace App\Http\Livewire\Logistique\NonFongible\Materiel;

use App\Enums\MouvementStatus;
use App\Http\Livewire\BaseComponent;
use App\Models\Materiel;
use App\Models\MaterielCategory;
use App\Models\Mouvement;
use App\Models\User;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MaterielShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public Materiel $materiel;
    public Mouvement $mouvement;
    public $categories = [];
    public $users = [];

    protected $rules = [
        'materiel.materiel_category_id' => 'required',
        'materiel.nom' => 'required',
        'materiel.description' => 'nullable',
        'materiel.montant' => 'required',
        'materiel.date' => 'nullable',
        'materiel.vie' => 'required',
        'materiel.status' => 'nullable',

        // Mouvement
        'mouvement.materiel_id' => 'nullable',
        'mouvement.user_id' => 'nullable',
        'mouvement.facilitateur_id' => 'nullable',
        'mouvement.beneficiaire' => 'nullable',
        'mouvement.date' => 'nullable',
        'mouvement.direction' => 'nullable',
        'mouvement.materiel_status' => 'nullable',
        'mouvement.observation' => 'nullable',
    ];

    public function mount(Materiel $materiel)
    {
        $this->authorize("view", $materiel);
        $this->materiel = $materiel;
        // dd($this->materiel);
        $this->loadData();
        $this->initMouvement();
    }

    public function loadData(): void
    {
        $this->categories = MaterielCategory::orderBy('nom', 'ASC')->get();
        $this->users = User::orderBy('name', 'ASC')->get();
        // dd($this->users);
    }

    public function initMouvement(): void
    {
        $this->mouvement = new Mouvement();
        $this->mouvement->date = Carbon::now()->format('Y-m-d');
        $this->mouvement->facilitateur_id = $this->users[0]->id;
        $this->mouvement->direction = MouvementStatus::in->name;
        $this->mouvement->materiel_status = $this->materiel->status->name;
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.non_fongibles.materiels.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur le matériel']);
    }

    public function getSelectedMouvement(Mouvement $mouvement)
    {
        $this->mouvement = $mouvement;
    }

    public function updateMateriel()
    {
        $this->validate();

        $done = $this->materiel->save();
        if ($done) {
            $this->onModalClosed('update-materiel-modal');
            $this->alert('success', "Matériel modifié avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de matériel !");
        }
        $this->materiel->refresh();
    }


    // Mouvement du matériel

    public function addMouvement()
    {
        $this->mouvement->materiel_id = $this->materiel->id;
        $this->mouvement->user_id = Auth::id();
        $this->validate([
            'mouvement.materiel_id' => 'required',
            'mouvement.user_id' => 'required',
            'mouvement.facilitateur_id' => 'required',
            'mouvement.beneficiaire' => 'required',
            'mouvement.date' => 'required',
            'mouvement.direction' => 'required',
            'mouvement.materiel_status' => 'required',
            'mouvement.observation' => 'nullable',
        ]);

        $done = $this->mouvement->save();
        if ($done) {
            $this->alert('success', $this->mouvement->direction->label() . " matériel ajoutée avec succès !");
            $this->onModalClosed('add-mouvement-modal');
        } else {
            $this->alert('warning', "Échec d'ajout de " . $this->mouvement->direction->label() . " matériel !");
        }

        $this->materiel->refresh();
    }

    public function updateMouvement()
    {
        $this->validate();
        $done = $this->mouvement->save();
        if ($done) {
            $this->onModalClosed('update-mouvement-modal');
            $this->alert('success', "Mouvement modifié avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de mouvement !");
        }
        $this->materiel->refresh();
    }

    public function deleteMouvement()
    {
        if ($this->mouvement->delete()) {
            $this->loadData();
            $this->alert('success', "Mouvement supprimé avec succès !");
        } else {
            $this->alert('warning', "Échec de suppression de mouvement !");
        }
        $this->onModalClosed('delete-mouvement-modal');
        $this->materiel->refresh();
    }

}
