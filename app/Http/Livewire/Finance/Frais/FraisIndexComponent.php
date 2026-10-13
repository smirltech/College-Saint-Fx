<?php

namespace App\Http\Livewire\Finance\Frais;


use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Frais;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class FraisIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;


    public $frais = [];
    // Étant donné que frais s'écrit de la même façon au singulier et au pluriel, j'utilise frais pour le pluriel et fee pour le singulier

    protected $listeners = ['fraisAdded' => 'reloadFrais'];

    //protected $listeners = ['onModalClosed'];

    public function mount(): void
    {
        $this->authorize('viewAny', Frais::class);
        $this->annee_id = Annee::id();
        $this->frais = Frais::get();
    }

    public function reloadFrais(): void
    {
        $this->frais = Frais::orderBy('nom')->get();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.frais.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Frais']);
    }

    // =================================================
}
