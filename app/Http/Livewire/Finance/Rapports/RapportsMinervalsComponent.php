<?php

namespace App\Http\Livewire\Finance\Rapports;

use App\Models\Etudiant;
use App\Models\Faculte;
use App\Models\Filiere;
use App\Models\Frais;
use App\Models\Perception;
use App\Models\Promotion;
use Carbon\Carbon;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Livewire\Component;
use Livewire\Redirector;
use Sabberworm\CSS\Value\URL;

class RapportsMinervalsComponent extends Component
{

    use AuthorizesRequests;

    public Collection $perceptions;
    public Collection $promotions;
    public Collection $facultes;
    public Collection $frais;

    public ?string $faculte_id = '';
    public ?string $promotion_id = '';
    public ?string $frais_id = '';
    public ?string $date_from = '';
    public ?string $date_to = '';

    public function mount(): void
    {
        $this->authorize('viewAny', Perception::class);

        $this->promotions = Promotion::get();
        $this->facultes = Faculte::with('filieres')->orderBy('nom')->get();
        $this->frais = Frais::orderBy('nom')->get();

        request()->validate([
            'date' => 'nullable|date',
        ]);

        $this->date_from = request()->query('date_from') ?? Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = request()->query('date_to') ?? Carbon::now()->format('Y-m-d');
        $this->promotion_id = request()->query('promotion_id');
        $this->faculte_id = request()->query('faculte_id');
        $this->frais_id = request()->query('frais_id');

    }

    public function getTitleProperty(): string
    {
        if ($this->faculte_id) {
            return 'Rapport financier de ' . Etudiant::find($this->faculte_id)?->label;
        }
        return 'Rapport financier du ' . now()->parse($this->date_from)->format('d/m/Y') . ' au ' . now()->parse($this->date_to)->format('d/m/Y') . ' | ' . Promotion::find($this->promotion_id)?->code ?? '';
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        return view(
            view: 'livewire.finance.rapports.minervals',)->with('title', 'Réservations')
            ->layoutData([
                'title' => __('Deposit Report'),
                'breadcrumbs' => [
                    ['label' => __('Dashboard'), 'url' => route('admin.admin')],

                ],
            ]);
    }

    public function search()
    {
        $this->frais = Frais::orderBy('nom')->get();

    }
}
