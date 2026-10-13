<?php

namespace App\Http\Livewire\Scolarite\Presences\Block;

use App\Models\Annee;
use App\Models\Classe;
use App\Models\Presence;
use App\Traits\TopMenuPreview;
use Carbon\Carbon;
use Exception;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class PresencesTableComponent extends Component
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

    protected $rules = [
        'presence.inscription_id' => 'required',
        'presence.date' => 'nullable',
        'presence.status' => 'required',
        'presence.observation' => 'nullable',

    ];


    public function mount(Classe $classe)
    {
        $this->classe = $classe;
        $this->loadData();
        $this->initPresence();

    }

    public function loadData()
    {
        $this->presences = $this->classe->presences->where('date', $this->current_date)->where('annee_id', Annee::id());
        $this->nonInscriptions = $this->classe->nonInscriptions($this->current_date);

        $this->hasNextDay = Carbon::parse($this->current_date)->isBefore(Carbon::now()->startOfDay());
        // dd($this->presences);
    }

    public function initPresence()
    {
        $this->current_date = $this->current_date ?? Carbon::now()->format('Y-m-d');
        $this->presence = new Presence();
        $this->presence->inscription_id = $this->nonInscriptions[0]->id ?? null;
        // dd($this->presence->inscription_id);
    }

    public function render()
    {
        $this->loadData();
        return view('livewire.scolarite.presences.blocks.table',
            [
                'presences' => $this->presences,
                'nonInscriptions' => $this->nonInscriptions,
            ]
        );
    }

    public function previousDate()
    {
        //->format('Y-m-d')
        $dd = Carbon::parse($this->current_date) ?? Carbon::now();
        $this->current_date = $dd->subDay()->format('Y-m-d');
    }

    public function nextDate()
    {
        //->format('Y-m-d')
        $dd = Carbon::parse($this->current_date) ?? Carbon::now();
        $ddo = $dd->addDay();
        if ($ddo->isBefore(Carbon::now()->endOfDay())) {
            $this->current_date = $ddo->format('Y-m-d');
        }
    }

    public function selectPresence($presence_id)
    {
        $this->presence = Presence::find($presence_id);
    }

    public function addPresence($status)
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

    public function updatePresence($status)
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

    public function deletePresence()
    {
        $done = $this->presence->delete();
        if ($done) {
            $this->onModalClosed('delete-presence');
            $this->alert('success', "Présence supprimée avec succès !");

        } else {
            $this->alert('warning', "Echec de suppression de présence !");
        }
    }


    public function printIt()
    {
        $this->loadData();
        $this->dispatchBrowserEvent('printIt', ['elementId' => "presencesPrint", 'type' => 'html', 'maxWidth' => '100%']);
    }
}
