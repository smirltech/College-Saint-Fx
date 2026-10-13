<?php

namespace App\Http\Livewire\Finance\Depenses;

use App\Enums\UserRole;
use App\Http\Livewire\BaseComponent;
use App\Models\Depense;
use App\Models\DepenseType;
use App\Notifications\DepenseCreated;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\URL;

class DepenseCreateComponent extends BaseComponent
{
    public array|Collection $types;
    public Depense $depense;
    public mixed $depense_media = null;

    public function mount(Depense $depense): void
    {

        //authorize if user can create depense or update depense
        if ($depense->exists) {
            $this->authorize('update', $depense);
        } else {
            $this->authorize('create', Depense::class);
        }

        $this->depense = $depense;
        $this->types = DepenseType::all();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.depenses.depense-create-component')->layoutData([
            'title' => $this->depense->exists ? 'Modifier une dépense' : 'Ajouter une dépense',
            'icon' => 'money-bill-wave',
            'breadcrumbs' => [
                ['url' => route('finance.depenses.index'), 'label' => 'Dépenses'],
            ],
        ]);
    }

    // submit
    public function submit(): void
    {
        $this->validate();
        $id = $this->depense->id;

        $this->depense->save();

        $this->depense->notifyAll(
            notification: new DepenseCreated($this->depense),
            roles: [UserRole::admin->value, UserRole::promoteur->value]
        );
        if ($id) {
            $this->success('Dépense modifiée avec succès');
        } else {
            $this->flashSuccess('Dépense enregistrée avec succès', URL::previous());
        }


    }

    public function submitAttachment(): void
    {
        $this->validate([
            'depense_media' => 'required|file|max:1024',
        ]);

        $this->depense->addMedia($this->depense_media);

        $this->flashSuccess('Pièce jointe ajoutée avec succès', route('finance.depenses.index'));
    }


    protected function rules(): array
    {
        return [
            'depense.depense_type_id' => 'required',
            'depense.montant' => 'required',
            'depense.motif' => 'required|string',
            'depense.devise' => 'required|string',
            'depense.beneficiaire' => 'nullable|string',
            'depense.reference' => 'nullable',
            'depense.date' => 'nullable|date',
            'depense.note' => 'nullable|string',
        ];
    }
}
