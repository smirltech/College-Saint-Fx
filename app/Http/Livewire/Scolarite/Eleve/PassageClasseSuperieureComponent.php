<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Http\Livewire\BaseComponent;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Annee;

class PassageClasseSuperieureComponent extends BaseComponent
{
    public $classes = [];
    public $eleves = [];
    public $search = '';
    public $eleve;
    public $nouvelleClasseId;
    public $annee;
    public $eleve_id;
    public $niveau;
    public $nouvelle_annee;
    public $inscritCetteAnnee = false;
    public $messageErreur = '';

    public function mount($id = null): void
    {
        $this->eleve   = $id ? Eleve::find($id) : null;
        $this->eleves  = Eleve::all();
        $this->classes = Classe::all();
    }

    public function updatedEleveId(string $eleve_id){
        $this->eleve = Eleve::find($eleve_id);


        if($this->eleve){
            $this->inscritCetteAnnee = Inscription::where('eleve_id', $this->eleve->id)
                ->where('annee_id', Annee::encours()->id)
                ->exists();

            if($this->inscritCetteAnnee){
                $this->messageErreur = "L'élève {$this->eleve->nom} est déjà inscrit pour l'année scolaire en cours (".Annee::encours()->nom.").";
            } else {
                $this->messageErreur = '';
            }
        }else{
            $this->inscritCetteAnnee = false;
            $this->messageErreur = '';
        }






    }



    public function passerClasse()
    {
        if (!$this->eleve) {
            session()->flash('error', "Veuillez sélectionner un élève !");
            return;
        }

        $annee = Annee::encours();

        try {
            Inscription::where('eleve_id', $this->eleve->id)
                ->create([
                    'eleve_id' => $this->eleve->id,
                    'classe_id' => $this->nouvelleClasseId,
                    'annee_id' => $annee->id,
                    'status'    => 'approved',
                ]);



            session()->flash('success',  "L'élève {$this->eleve->nom} a été inscrit !");

            $this->dispatchBrowserEvent('refresh-page');

        } catch (\Illuminate\Database\QueryException $e) {
            if ($e->getCode() == 23000) {
                session()->flash('error', "Cet élève est déjà inscrit dans cette classe pour l'année en cours !");
                return;
            }
            session()->flash('error', "Erreur SQL : " . $e->getMessage());

        } catch (\Exception $e) {
            session()->flash('error', "Erreur : " . $e->getMessage());
        }


    }
    public function render()
    {

        return view('livewire.scolarite.eleves.passage-classe-superieure-component', [
            'classes' => $this->classes,
            'eleve'   => $this->eleve,
            'eleves'  => $this->eleves,
        ]);
    }
}
