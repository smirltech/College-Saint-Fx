<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\Devise;
use App\Enums\UserRole;
use App\Helpers\Helpers;
use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Consommable;
use App\Models\Depense;
use App\Models\Enseignant;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Materiel;
use App\Models\Perception;
use App\Models\User;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\Auth;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Redirector;

class PerceptionIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $perception;

    public ?string $classe_id = null;
    public ?string $annee_id = null;
    public ?string $frais_id = null;
    public ?string $frais_type = null;

    public function mount(): void
    {
        $this->authorize('viewAny', Perception::class);

        $this->classe_id = request()->get('classe_id') ?: null;
        $this->frais_id = request()->get('frais_id') ?: null;
        $this->frais_type = request()->get('frais_type') ?: null;

        $this->annee_id = Annee::id();
        $this->classes = Classe::all();
        $this->frais = Frais::all();

    }
    public function getPerceptionsProperty(): Collection
    {
        $perceptionsRequest = Perception::when($this->classe_id, function ($q) {
            $q->whereHas('inscription', function ($q) {
                $q->where('classe_id', $this->classe_id);
            });
        })->when($this->frais_id, function ($q) {
            $q->where('frais_id', $this->frais_id);
        })->when($this->frais_type, function ($q) {
            $q->whereHas('frais', function ($q2) {
                $q2->whereType($this->frais_type);
            });
        });

        if ($this->frais_id or $this->classe_id or $this->frais_type) {
            return $perceptionsRequest->latest()->get();
        }

        return $perceptionsRequest->latest()->limit(1000)->get();
    }
    public function getBoxesProperty(): array
    {

        $perceptionQuery = Perception::when($this->classe_id, function ($q) {
            $q->whereHas('inscription', function ($q) {
                $q->where('classe_id', $this->classe_id);
            });
        })->when($this->frais_id, function ($q) {
            $q->where('frais_id', $this->frais_id);
        })->when($this->frais_type, function ($q) {
            $q->whereHas('frais', function ($q2) {
                $q2->whereType($this->frais_type);
            });
        });


        $perceptionsUSD = Helpers::currencyFormat($perceptionQuery->clone()->whereDevise('USD')->sum('montant'));
        $perceptionsCDF = Helpers::currencyFormat($perceptionQuery->clone()->whereDevise(Devise::CDF)->sum('montant'));

        $perceptionsTodayUSD = $perceptionQuery->clone()->ofToday()->whereDevise('USD')->sum('montant');
        $perceptionsTodayCDF = $perceptionQuery->clone()->ofToday()->whereDevise('CDF')->sum('montant');

        $perceptionsMeTodayUSD = $perceptionQuery->clone()->ofToday()->whereDevise('USD')->whereUserId(Auth::id())->sum('montant');
        $perceptionsMeTodayCDF = $perceptionQuery->clone()->ofToday()->whereDevise('CDF')->whereUserId(Auth::id())->sum('montant');


        return [
            [
                'title' => "{$perceptionsCDF}Fc / {$perceptionsUSD}$",
                'text' => 'Perceptions',
                'icon' => 'fas fa-coins',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
            [
                'title' => "{$perceptionsTodayCDF}Fc / {$perceptionsTodayUSD}$",
                'text' => "Aujoud'hui",
                'icon' => 'fas fa-coins',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
            [
                'title' => '$' . Depense::total(),
                'text' => 'Depenses',
                'icon' => 'fas fa-credit-card',
                'theme' => 'gradient-danger',
                'url' => '#'

            ],
            [
                'title' => "{$perceptionsMeTodayCDF}Fc / {$perceptionsMeTodayUSD}$",
                'text' => "Aujoud'hui",
                'icon' => 'fas fa-user',
                'theme' => 'gradient-success',
                'url' => \route('finance.perceptions')

            ],
        ];
    }

    public function render()
    {

        return view('livewire.finance.perceptions.index', ['perceptions' => $this->perceptions])
            ->layout(AdminLayout::class, ['title' => 'Liste de Perceptions']);
    }



    public function getSelectedPerception(Perception $perception): void
    {
        $this->perception = $perception;

    }

    public function deletePerception(): void
    {

        if ($this->perception->delete()) {
            $this->alert('success', "Perception supprimée avec succès !");
            $this->dispatchBrowserEvent('closeModal', ['modal' => 'delete-perception']);
        }

        $this->onModalClosed();

    }

    public function search(): RedirectResponse|Redirector
    {
        return redirect()->route('finance.perceptions', [
            'classe_id' => $this->classe_id,
            'frais_id' => $this->frais_id,
            'frais_type' => $this->frais_type,
        ]);
    }


}
