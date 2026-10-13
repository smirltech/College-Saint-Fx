<?php

namespace App\Http\Livewire\Finance\Revenu;

use App\Enums\RevenuType;
use App\Http\Livewire\BaseComponent;
use App\Models\Revenu;
use App\Traits\TopMenuPreview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\URL;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RevenuCreateComponent extends BaseComponent
{
    use LivewireAlert;

    public Revenu $revenu;

    public array $types;

    public function mount(Revenu $revenu): void
    {
        $this->revenu = $revenu;
        $this->types = RevenuType::cases();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view('livewire.finance.revenus.create');
    }

    public function rules(): array
    {
        return [
            'revenu.type' => 'required',
            'revenu.montant' => 'required',
            'revenu.nom' => 'required',
            'revenu.devise' => 'required',
            'revenu.description' => 'nullable',
        ];
    }

    public function submit(): void
    {
        $this->validate();
        $this->revenu->save();
        $this->flashSuccess('Revenu enregistré avec succès', URL::previous());
    }

}
