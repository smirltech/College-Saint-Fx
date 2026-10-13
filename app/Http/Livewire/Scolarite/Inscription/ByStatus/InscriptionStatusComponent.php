<?php

namespace App\Http\Livewire\Scolarite\Inscription\ByStatus;

use App\Enums\InscriptionStatus;
use App\Models\Annee;
use App\Models\Inscription;
use App\View\Components\AdminLayout;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class InscriptionStatusComponent extends Component
{
    use LivewireAlert;
    use WithPagination;

    public $annee_courante;

    public $status;

    public function mount(InscriptionStatus $status): void
    {
        $this->status = $status;
    }

    public function render()
    {
        $this->annee_courante = Annee::where('encours', true)->first();

        #TODO: move this to mount()
        $inscriptions = $this->loadData();

        return view("livewire.scolarite.inscriptions.bystatus.status", [
            'inscriptions' => $inscriptions->get(),
        ])
            ->layout(AdminLayout::class, ['title' => "Liste d'inscriptions " . $this->status->label()]);
    }

    public function loadData()
    {
        $query = Inscription::query();
        $query->where(['annee_id' => $this->annee_courante->id, 'status' => $this->status])->orderBy('status', 'ASC');
        return $query;
    }

    public function deleteInscription($id)
    {
        $this->alert('info', "Cette fonctionnalité n'est pas encore implémentée !");
    }
}

