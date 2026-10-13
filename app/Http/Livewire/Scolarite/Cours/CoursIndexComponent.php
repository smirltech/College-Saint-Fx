<?php

namespace App\Http\Livewire\Scolarite\Cours;

use App\Http\Livewire\BaseComponent;
use App\Models\Cours;
use App\Traits\CanDeleteModel;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class CoursIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert, CanDeleteModel;

    public $cours = [];
    public ?Cours $cour = null;

    public function mount(): void
    {
        $this->authorize('viewAny', Cours::class);
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.cours.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de cours']);
    }


    public function loadData()
    {
        $this->cours = Cours::latest()->get();
    }

    /*  public function deleteCours(Cours $cours)
      {
          $this->deleteModel($cours, 'Cours supprimé avec succès', 'Ce cours est attaché à un enseignant ou à une classe');
      }*/

    public function getSelectedCours($cours_id)
    {
        $this->cour = Cours::find($cours_id);
    }

    public function deleteCours()
    {
        try {
            if ($this->cour->delete()) {
                $this->loadData();
                $this->alert('success', "Cours supprimé avec succès !");
            } else {
                $this->alert('warning', "Échec de suppression de cours !");
            }
        } catch (Exception $e) {
            $this->alert('error', "Cours n'a pas été supprimé, il y a des éléments attachés !");
        }

        $this->onModalClosed('delete-cours');
    }
}
