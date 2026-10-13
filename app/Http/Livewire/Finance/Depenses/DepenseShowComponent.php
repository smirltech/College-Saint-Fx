<?php

namespace App\Http\Livewire\Finance\Depenses;

use App\Http\Livewire\BaseComponent;
use App\Models\Depense;
use App\Models\DepenseType;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class DepenseShowComponent extends BaseComponent
{
    public array|Collection $types;
    public Depense $depense;
    public ?string $status_note = null;
    public mixed $depense_statuses;

    protected $listeners = ['refresh' => '$refresh'];

    public function mount(Depense $depense): void
    {
        $this->loadData($depense);
    }

    private function loadData(Depense $depense): void
    {
        $this->depense = $depense;
        $this->depense_statuses = $depense->statuses;
        $this->types = DepenseType::all()->toArray();
    }

    // submit

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.depenses.depense-show-component')->layoutData([
            'title' => "Détails de la dépense - {$this->depense->montant} {$this->depense?->devise?->value}",
            'icon' => 'money-bill-wave',
            'breadcrumbs' => [
                ['url' => route('finance.depenses.index'), 'label' => 'Dépenses'],
            ],
        ]);
    }

    public function rejectDepense(): void
    {
        if (!$this->status_note) {
            $this->warning('Veuillez ajouter une note pour expliquer la raison du rejet');
            return;
        }
        try {
            $this->depense->reject($this->status_note);
            $this->success('Dépense rejetée avec succès');
            $this->emit('refresh');
        } catch (Exception $e) {
            $this->error(local: $e->getMessage());
        }


    }

    public function approveDepense(): void
    {

        try {
            $this->depense->approve($this->status_note);
            $this->success('Dépense approuvée avec succès');
            $this->emit('refresh');

        } catch (Exception $e) {
            $this->error(local: $e->getMessage());
        }

    }

    protected function rules(): array
    {
        return [
            'status_note' => 'required|string',
        ];
    }


}
