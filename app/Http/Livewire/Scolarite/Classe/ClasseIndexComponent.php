<?php

namespace App\Http\Livewire\Scolarite\Classe;

use App\Http\Livewire\BaseComponent;
use App\Models\Classe;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class ClasseIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $classes = [];
    public ?Classe $classe = null;

    public function mount(): void
    {
        $this->authorize('viewAny', Classe::class);
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.classes.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Classes']);
    }


    public function loadData()
    {
        $this->classes = Classe::orderBy('section_id')->orderBy('code')->get();
    }


    public function getSelectedClasse($classe_id)
    {
        $this->classe = Classe::find($classe_id);
    }

    public function deleteClasse()
    {
        try {
            if ($this->classe->delete()) {
                $this->loadData();
                $this->alert('success', "Classe supprimée avec succès !");
            } else {
                $this->alert('warning', "Échec de suppression de classe !");
            }
        } catch (Exception $e) {
            $this->alert('error', "Classe n'a pas été supprimée, il y a des éléments attachés !");
        }

        $this->onModalClosed('delete-classe');
    }
}
