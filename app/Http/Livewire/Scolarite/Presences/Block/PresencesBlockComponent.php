<?php

namespace App\Http\Livewire\Scolarite\Presences\Block;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Presence;
use App\Traits\TopMenuPreview;
use Carbon\Carbon;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;
use Livewire\WithPagination;

class PresencesBlockComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;
    use WithPagination;


    public Classe $classe;
    public $presences = [];
    public $nonInscriptions = [];

    //public $resultats = [];
    public Presence $presence;

    public bool $hasNextDay = false;
    public $current_date;
    public ?Eleve $presence_eleve;
    protected $rules = [
        'presence.inscription_id' => 'required',
        'presence.date' => 'nullable',
        'presence.status' => 'required',
        'presence.observation' => 'nullable',

    ];

    #[NoReturn] public function mount(Classe $classe): void
    {
        $this->classe = $classe;
        $this->loadData();
        $this->initPresence();

    }

    #[NoReturn] public function loadData(): void
    {
        $this->presences = $this->classe->presences;
        $this->nonInscriptions = $this->classe->inscriptions;
        $this->presence_eleve = ($this->nonInscriptions[0] ?? null)?->eleve;

        $this->hasNextDay = Carbon::parse($this->current_date)->isBefore(Carbon::now()->startOfDay());

    }

    public function initPresence(): void
    {
        $this->current_date = $this->current_date ?? Carbon::now()->format('Y-m-d');
        $this->presence = new Presence();
        $this->presence->inscription_id = $this->nonInscriptions[0]->id ?? null;
    }

    #[NoReturn] public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->loadData();
        return view('livewire.scolarite.presences.blocks.list',
            [
                'presences' => $this->presences,
                'nonInscriptions' => $this->nonInscriptions,
            ]
        );
    }

    public function previousDate(): void
    {
        //->format('Y-m-d')
        $dd = Carbon::parse($this->current_date) ?? Carbon::now();
        $this->current_date = $dd->subDay()->format('Y-m-d');
    }

    public function nextDate(): void
    {
        //->format('Y-m-d')
        $dd = Carbon::parse($this->current_date) ?? Carbon::now();
        $ddo = $dd->addDay();
        if ($ddo->isBefore(Carbon::now()->endOfDay())) {
            $this->current_date = $ddo->format('Y-m-d');
        }
    }

    public function selectPresence($presence_id): void
    {
        $this->presence = Presence::find($presence_id);
    }

    public function addPresence($status): void
    {
        $this->presence->status = $status;
        $this->presence->date = $this->current_date;
        $this->presence->annee_id = Annee::id();
        $this->validate([
            'presence.inscription_id' => 'required',
            'presence.date' => 'required',
            'presence.status' => 'required',
            'presence.observation' => 'nullable',
        ]);
        //dd($this->presence);
        try {
            $done = $this->presence->save();
            if ($done) {

                $this->classe->refresh();
                $this->loadData();
                $this->initPresence();
                $this->alert('success', "Présence ajoutée avec succès !");
                if ($this->nonInscriptions->count() == 0) {
                    $this->onModalClosed('add-presence');
                }
            } else {
                $this->alert('warning', "Echec d'ajout de présence !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Echec de d'ajout de présence qui existe sur cette date déjà !");
        }
    }


    public function updatePresence($status): void
    {
        $this->presence->status = $status;
        $this->validate([
            'presence.date' => ['required', Rule::unique('presences', 'date')->ignore($this->presence, 'date'),],
            'presence.observation' => 'nullable',
        ]);

        try {
            $done = $this->presence->update();
            if ($done) {
                $this->onModalClosed('update-presence');
                $this->alert('success', "Présence modifiée avec succès !");

            } else {
                $this->alert('warning', "Echec de modification de présence !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Echec de modification de présence qui existe sur cette date déjà !");
        }
    }

    public function deletePresence(): void
    {
        $done = $this->presence->delete();
        if ($done) {
            $this->onModalClosed('delete-presence');
            $this->alert('success', "Présence supprimée avec succès !");

        } else {
            $this->alert('warning', "Echec de suppression de présence !");
        }
    }

    public function printIt(): void
    {
        $this->loadData();
        $this->dispatchBrowserEvent('printIt', ['elementId' => "presencesPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
