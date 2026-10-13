<?php

namespace App\Http\Livewire\Scolarite\Eleve;


use App\Models\Eleve;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;
use SmirlTech\LaravelFullcalendar\Calendar;

class PresenceComponent extends Component
{
    public string $calendar_script;
    public string $calendar_view;
    public Eleve $eleve;
    private Calendar $calendar;

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.eleves.presence-component');
    }

    // mount
    public function mount(Eleve $eleve)
    {

        $this->eleve = $eleve;

        $evt = [];
        $this->calendar = \Calendar::addEvents($eleve->presences)
            ->setOptions([ //set fullcalendar options
                'initialView' => 'listWeek',
                'locale', 'fr'
            ])
            ->setCallbacks([ //set fullcalendar callback options (will not be JSON encoded)
                'eventClick' => 'function(info) {alert(info.event.id);}'
            ]);

        $this->calendar_view = $this->calendar->calendar();
        $this->calendar_script = $this->calendar->scriptToHtml();


    }
}
