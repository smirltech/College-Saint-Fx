<?php

namespace App\Http\Livewire\Scolarite\Resultat;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Responsable;
use App\Models\Resultat;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class ResultatIndexComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;
    use WithPagination;

    public $resultats = [];
    public Classe $classe;


    protected $listeners = ['onModalClosed'];

    public function mount(Classe $classe)
    {
        $this->classe = $classe;
        #TODO: move this to mount()
        $this->resultats = $this->loadData();
        dd($this->resultats);
    }

    public function loadData()
    {
        return Resultat::where('annee_id', Annee::id())->whereHas('eleves', function ($q) {
            $q->where('classe_id', $this->classe->id);
        })->get();

    }

    public function render()
    {
        $this->responsables = $this->loadData();

        return view('livewire.scolarite.resultats.index')
            ->layout(AdminLayout::class, ['title' => "Liste de resultats"]);
    }

    public function addThisResponsable()
    {

        $this->validate([
            'responsable_nom' => 'required|string',
            'responsable_sexe' => 'nullable',
            'responsable_telephone' => 'nullable|string',
            'responsable_email' => 'nullable',
            'responsable_adresse' => 'nullable',
        ]);

        Responsable::create([
            'nom' => $this->responsable_nom,
            'sexe' => $this->responsable_sexe,
            'telephone' => $this->responsable_telephone,
            'email' => $this->responsable_email,
            'adresse' => $this->responsable_adresse,
        ]);

        // close the modal by specifying the id of the modal
        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-responsable-modal']);
        $this->onModalClosed();


    }


    public function deleteResponsable($responsable_id)
    {
        $responsable = Responsable::find($responsable_id);
        // dd($responsable);
        if (count($responsable->responsable_eleves) == 0) {
            if ($responsable->delete()) {
                $this->loadData();
                $this->alert('success', "Responsable supprimé avec succès !");
                // $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-section-modal']);
            }
        } else {
            $this->alert('warning', "Responsable n'a pas été supprimé, il y a des élèves attachés !");
        }

    }

}
