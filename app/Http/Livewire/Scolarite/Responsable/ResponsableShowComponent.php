<?php

namespace App\Http\Livewire\Scolarite\Responsable;

use App\Http\Livewire\BaseComponent;
use App\Models\Responsable;
use App\Models\ResponsableEleve;
use App\Models\User;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ResponsableShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $responsable;
    public $nom;
    public $sexe;
    public $telephone;
    public $email;
    public $adresse;

    public ?ResponsableEleve $responsable_eleve;
    public $responsable_relation;

    protected $rules = [
        'nom' => 'required|string',
        'sexe' => 'nullable',
        'telephone' => 'nullable|string',
        'email' => 'nullable',
        'adresse' => 'nullable',
    ];

    protected $listeners = ['onModalClosed'];


    public function mount(Responsable $responsable): void
    {
        $this->authorize('view', $responsable);
        $this->responsable = $responsable;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->reloadData();
        return view('livewire.scolarite.responsables.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur le responsable']);
    }

    public function reloadData(): void
    {
        $this->responsable = Responsable::find($this->responsable->id);
    }

    public function selectResponsableEleve($relationEleve_id): void
    {
        $this->responsable_eleve = ResponsableEleve::find($relationEleve_id);
        $this->responsable_relation = $this->responsable_eleve->relation;
    }

    public function fillDataToModal()
    {
        $this->nom = $this->responsable->nom;
        $this->sexe = $this->responsable->sexe;
        $this->telephone = $this->responsable->telephone;
        $this->email = $this->responsable->email;
        $this->adresse = $this->responsable->adresse;
    }

    public function submitResponsable(): void
    {
        if (isset($this->nom)) {
            $this->responsable->update([
                'nom' => $this->nom,
                'sexe' => $this->sexe,
                'telephone' => $this->telephone,
                'email' => $this->email,
                'adresse' => $this->adresse,
            ]);


            // close the modal by specifying the id of the modal
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-responsable-modal']);
            $this->onModalClosed();
        }

    }

    public function deleteResponsable(): void
    {
        if (count($this->responsable->responsable_eleves) == 0) {
            ResponsableEleve::where('responsable_id', $this->responsable->id)->delete();
            if ($this->responsable->delete()) {
                //$this->loadData();
                // $this->alert('success', "Responsable supprimé avec succès !");
                // $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-responsable-modal']);
                $this->flash('success', 'Responsable supprimé avec succès', [], route('scolarite.responsables.index'));

            }
        } else {

            $this->alert('warning', "Responsable n'a pas été supprimé, il y a des élèves attachés !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-responsable-modal']);
            $this->onModalClosed();
        }

    }

    public function editRelation(): void
    {

        $done = $this->responsable_eleve->update([
            'relation' => $this->responsable_relation,
        ]);

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Relation modifiée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-relation-modal']);
        } else {
            $this->alert('warning', "Echec de modification de relation !");
        }
        $this->onModalClosed();

    }

    public function deleteRelation(): void
    {

        $done = $this->responsable_eleve->delete();

        if ($done) {
            $this->reloadData();
            $this->alert('success', "Relation supprimée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-relation-modal']);
        } else {
            $this->alert('warning', "Echec de suppression de relation !");
        }
        $this->onModalClosed();

    }


    // create user for responsable
    public function addUserToResponsable(): void
    {
        if ($this->responsable->user == null) {
            $user = User::create([
                'name' => $this->nom,
                'email' => $this->email,
                'password' => 'password',
            ]);
            $user->assignRole('parent');
            $this->responsable->update([
                'user_id' => $user->id,
            ]);
            $this->alert('success', "Compte responsable a été ajouté avec succès ! Un email a été envoyé avec le mot de passe !");
        } else {
            $this->responsable->user->update([
                'password' => 'password',
            ]);
            $this->alert('warning', "Responsable a déjà un compte ! Mais un email a été envoyé avec le mot de passe !");
        }
        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'edit-responsable-user-modal']);
        $this->onModalClosed();


    }

}
