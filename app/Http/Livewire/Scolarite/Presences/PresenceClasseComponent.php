<?php

namespace App\Http\Livewire\Scolarite\Presences;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Presence;
use App\Models\Section;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\WithPagination;

class PresenceClasseComponent extends Component
{
    use HasLivewireAlert;

    public ?Presence $presence;

    public function mount(): void
    {
        $this->presence = new Presence();
        $this->classes = Classe::orderBy('section_id')->orderBy('niveau')->get();
        $this->presence->date = Carbon::now()->toDateString();
    }

    public function updatedPresenceClasseId(): void
    {
        $this->loadPresence();
    }

    public function updatedPresenceDate(): void
    {
        $this->loadPresence();

    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.scolarite.presences.create-classe-presence');
    }

    public function updatedPresenceGarcons($value): void
    {
        $this->presence->total = (int)$this->presence->filles + (int)$value;

    }

    public function updatedPresenceFilles($value): void
    {
        $this->presence->total = (int)$this->presence->garcons + (int)$value;
    }

    public function submit(): void
    {
        $this->validate();
        $this->presence->save();

        $this->flashSuccess('La présence a été enregistrée avec succès', URL::previous());
        $this->presence = new Presence();
    }

    public function rules(): array
    {
        return [
            'presence.classe_id' => 'required',
            'presence.date' => 'required',
            'presence.garcons' => 'numeric|nullable',
            'presence.filles' => 'numeric|nullable',
            'presence.absents' => 'numeric|nullable',
            'presence.total' => 'numeric|required',
            'presence.observation' => 'nullable',
        ];
    }

    private function loadPresence(): void
    {
        $presence = Presence::where('classe_id', $this->presence->classe_id)
            ->whereDate('date', $this->presence->date)
            ->first();

        if ($presence) {
            $this->presence = $presence;
        } else {
            $this->presence->garcons = 0;
            $this->presence->filles = 0;
            $this->presence->absents = 0;
            $this->presence->total = 0;
            $this->presence->observation = null;
        }
    }
}
