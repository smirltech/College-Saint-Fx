<?php

namespace App\Http\Livewire\Scolarite\Responsables;

use App\Http\Livewire\BaseComponent;
use App\Models\Responsable;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

//TODO: move the creation and update of Responsable to this separate component
class ResponsableCreateComponent extends BaseComponent
{

    public Responsable $responsable;
    protected $rules = [
        'nom' => 'required|string',
        'sexe' => 'nullable',
        'telephone' => 'nullable|string',
        'email' => 'nullable',
        'adresse' => 'nullable',
    ];

    public function mount(Responsable $responsable): void
    {
        $this->authorize('create', Responsable::class);

        $this->responsable = $responsable;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.scolarite.responsables.responsable-create-component');
    }
}
