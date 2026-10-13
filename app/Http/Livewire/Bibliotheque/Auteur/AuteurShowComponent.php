<?php

namespace App\Http\Livewire\Bibliotheque\Auteur;

use App\Http\Livewire\BaseComponent;
use App\Models\Auteur;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Support\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class AuteurShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public Auteur $auteur;

    public Collection $ouvrages;

    public $etiquettes = [];


    public function mount(Auteur $auteur)
    {
        $this->authorize("view", $auteur);
        $this->auteur = $auteur;

    }

    public function render()
    {
        $this->loadData();
        return view('livewire.bibliotheque.auteurs.show')
            ->layout(AdminLayout::class, ['title' => "Détail sur l'auteur"]);
    }

    public function loadData(): void
    {

    }

}
