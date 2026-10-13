<?php

namespace App\Http\Livewire\Bibliotheque\Auteur;

use App\Http\Livewire\BaseComponent;
use App\Models\Auteur;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AuteurIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    // protected $paginationTheme = 'bootstrap';

    public Auteur $auteur;
    protected $rules = [
        'auteur.nom' => 'required',
        'auteur.prenom' => 'nullable',
        'auteur.sexe' => 'required',
    ];
    private $auteurs = [];

    public function mount()
    {
        $this->authorize("viewAny", Auteur::class);
        $this->initAuteur();
        $this->loadData();
    }

    public function initAuteur()
    {
        $this->auteur = new Auteur();
    }

    public function loadData()
    {
        $this->auteurs = Auteur::orderBy('nom')->get();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.bibliotheque.auteurs.index', ['auteurs' => $this->auteurs])
            ->layout(AdminLayout::class, ['title' => "Liste d'Auteurs"]);
    }


    public function addAuteur()
    {
        $this->validate();

        try {
            $done = $this->auteur->save();
            if ($done) {
                $this->onModalClosed('add-auteur-modal');
                $this->loadData();
                $this->initAuteur();
                $this->alert('success', "Auteur ajouté avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout d'auteur !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout d'auteur, ce nom existe déjà !");
        }

    }

    public function getSelectedAuteur(Auteur $auteur)
    {
        $this->auteur = $auteur;
    }

    public function updateAuteur()
    {
        $this->validate();

        $done = $this->auteur->save();
        if ($done) {
            $this->onModalClosed('update-auteur-modal');
            $this->alert('success', "Auteur modifié avec succès !");
        } else {
            $this->alert('warning', "Échec de modification d'auteur !");
        }

    }

    public function deleteAuteur()
    {
        if ($this->auteur->delete()) {
            $this->loadData();
            $this->alert('success', "Auteur supprimé avec succès !");
        } else {
            $this->alert('warning', "Auteur n'a pas été supprimé, il y a des éléments attachés !");
        }
        $this->onModalClosed('delete-auteur-modal');

    }

}
