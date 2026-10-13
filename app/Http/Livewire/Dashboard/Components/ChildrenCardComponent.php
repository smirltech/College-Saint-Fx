<?php

namespace App\Http\Livewire\Dashboard\Components;

use App\Models\Eleve;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ChildrenCardComponent extends Component
{

    public Collection $eleves;

    public function mount(): void
    {
        //TODO: we should consider removing the fallback to all eleves
        $this->eleves = Auth::user()->eleves ?? Eleve::all();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.dashboard.components.children-card-component');
    }
}
