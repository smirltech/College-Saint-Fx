<?php

namespace App\Http\Livewire\Dashboard\Components;

use App\Enums\PresenceStatus;
use App\Models\Eleve;
use App\Models\Inscription;
use App\Models\Presence;
use Auth;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Livewire\Component;

class ChildrenPresencesDonutChart extends Component
{

    public array $dataset = [];
    public array $labels = [];
    public ?Collection $eleves;
    /**
     * @var mixed|string|null
     */
    public mixed $eleve_id;

    /**
     * Create a new component instance.
     */
    public function mount(): void
    {
        //TODO: we should consider removing the fallback to all eleves
        $this->eleves = Auth::user()->eleves ?? Eleve::all();
        $this->eleve_id = $this->eleves->first()->id ?? null;


        $this->makeDataset();
    }

    public function makeDataset(): void
    {
        $inscription = Inscription::anneeScolaire()->where('eleve_id', $this->eleve_id)->first();

        $presences = Presence::where('inscription_id', $inscription->id)->where('status', PresenceStatus::PRESENT->value)->count();
        $absences = Presence::where('inscription_id', $inscription->id)->where('status', PresenceStatus::ABSENT->value)->count();
        $this->labels = [
            'Présences - ' . $presences,
            'Absences - ' . $absences,
        ];


        $this->dataset = [
            [
                'backgroundColor' => ['#3e95cd', '#8e5ea2'],
                'data' => [
                    $presences,
                    $absences,
                ]
            ],
        ];
    }

    public function updatedEleveId(): void
    {
        $this->makeDataset();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.dashboard.components.children-presences-donut-chart');
    }
}
