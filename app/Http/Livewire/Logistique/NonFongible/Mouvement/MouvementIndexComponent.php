<?php

namespace App\Http\Livewire\Logistique\NonFongible\Mouvement;

use App\Http\Livewire\BaseComponent;
use App\Models\Mouvement;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class MouvementIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $mouvements = [];

    public function mount()
    {
        $this->authorize("viewAny", Mouvement::class);
        $this->loadData();
    }

    public function loadData()
    {
        $this->mouvements = Mouvement::orderBy('date', 'DESC')->get();
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.logistiques.non_fongibles.mouvements.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Mouvements']);
    }

}
