<?php

namespace App\Http\Livewire\Scolarite\Annee;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AnneeComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $annees;
    public Annee $annee;
    public $title = "Années scolaires";


    protected $rules = [
        'annee.date_debut' => 'required',
        'annee.date_fin' => 'required',
    ];

    public function mount()
    {
        $this->authorize("viewAny", Annee::class);
        $this->initAnnee();
        $this->loadData();
    }

    public function initAnnee()
    {
        $this->annee = new Annee();
    }

    public function loadData()
    {
        $this->annees = Annee::orderBy('encours', 'DESC')->orderBy('date_debut', 'DESC')->get();
    }

    public function getSelectedAnnee($id)
    {
        $this->annee = Annee::find($id);
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.annees.index')
            ->layout(AdminLayout::class)->layoutData(['title' => $this->title, "contentHeaderIcon" => "fas fa-fw fa-calendar-alt"]);
    }

    public function addAnnee()
    {
        $this->validate();

        $done = $this->annee->save();
        if ($done) {
            $this->onModalClosed('add-annee-modal');
            $this->initAnnee();
            $this->alert('success', "Consommable ajouté avec succès !");
        } else {
            $this->alert('warning', "Échec d'ajout de consommable !");
        }
    }

    public function deleteAnnee()
    {

        try {
            if ($this->annee->delete()) {
                $this->onModalClosed('delete-annee-modal');
                $this->initAnnee();
                $this->alert('success', "Année scolaire supprimée avec succès !");
            } else {
                $this->alert('warning', "Échec de suppression d'année scolaire !");
            }
        } catch (Exception $e) {
            $this->alert('error', "Année scolaire n'a pas été supprimée, il y a des éléments attachés !");
        }
    }


    public function setAnneeEnCours($id)
    {

        $aa = Annee::find($id);

        Annee::query()->where('encours', true)->update(['encours' => false]);
        $aa->encours = true;
        $aa->save();
        $this->alert('success', 'Année en cours modifiée avec succès');
        // }
        //$this->onModalClosed('delete-consommable-modal');
    }


    public function updateAnnee()
    {
        $this->validate();

        $done = $this->annee->save();
        if ($done) {
            $this->onModalClosed('update-annee-modal');
            $this->alert('success', "Année modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification d'année !");
        }

    }

}
