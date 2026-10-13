<?php

namespace App\Http\Livewire\Dashboard\Components;

use App\Models\Depense;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class DepensesRecentesCard extends Component
{
    public Collection $depenses;

    public function mount(): void
    {
        $this->depenses = Depense::paid()->limit(5)->latest()->get();
    }

    public function render(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('livewire.dashboard.components.depenses-recentes-card');
    }
}
