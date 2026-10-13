<?php

namespace App\Http\Livewire\Scolarite\Devoir;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Cours;
use App\Models\Devoir;
use App\Traits\CanDeleteModel;
use App\Traits\TopMenuPreview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class DevoirIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert, CanDeleteModel;

    public Collection $devoirs;

    public function mount(): void
    {
        $this->authorize('viewAny', Devoir::class);
    }

    public function render(): Factory|View|Application
    {
        $this->loadData();
        return view('livewire.scolarite.devoirs.index');
    }


    public function loadData(): void
    {
        $this->devoirs = Devoir::where('annee_id', Annee::id())->latest()->get();
    }

    public function deleteCours(Cours $cours)
    {
        $this->deleteModel($cours, 'Cours supprimé avec succès', 'Ce cours est attaché à un enseignant ou à une classe');
    }
}
