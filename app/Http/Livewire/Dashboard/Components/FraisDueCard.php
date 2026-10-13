<?php

namespace App\Http\Livewire\Dashboard\Components;

use App\Models\Perception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class FraisDueCard extends Component
{
    public Collection $perceptions;

    public function mount(): void
    {
        $this->perceptions = Perception::limit(5)->latest()->get();
    }

    public function render(): Factory|\Illuminate\Foundation\Application|View|Application
    {
        return view('livewire.dashboard.components.frais-due-card');
    }
}
