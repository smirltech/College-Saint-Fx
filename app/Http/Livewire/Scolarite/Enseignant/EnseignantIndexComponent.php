<?php

namespace App\Http\Livewire\Scolarite\Enseignant;

use App\Http\Livewire\BaseComponent;
use App\Models\Enseignant;
use App\Traits\CanDeleteModel;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class EnseignantIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;
    use CanDeleteModel;

    public Collection $enseignants;
    public Enseignant|null $enseignant = null;

    public function mount()
    {
        $this->authorize("viewAny", Enseignant::class);
        $this->loadData();
    }

    public function loadData()
    {
        $this->enseignants = Enseignant::latest()->get();
    }

    public function render()
    {
        $data = ['title' => 'Liste d\'enseignants'];
        return view('livewire.scolarite.enseingnants.index', $data)
            ->layout(AdminLayout::class, $data);
    }


    /* public function delete(Enseignant $enseignant)
     {
         $this->deleteModel($enseignant, 'Enseignant supprimé avec succès');
     }*/

    public function getSelectedEnseignant($enseignant_id)
    {
        // dd( $enseignant_id );
        $this->enseignant = Enseignant::find($enseignant_id);
        //dd( $this->enseignant );
    }

    public function deleteEnseignant()
    {
        try {
            if ($this->enseignant->delete()) {
                $this->loadData();
                $this->alert('success', "Enseignant supprimé avec succès !");
            } else {
                $this->alert('warning', "Échec de suppression d'enseignant !");
            }
        } catch (Exception $e) {
            $this->alert('error', "Enseignant n'a pas été supprimé, il y a des éléments attachés !");
        }

        $this->onModalClosed('delete-enseignant');
    }
}
