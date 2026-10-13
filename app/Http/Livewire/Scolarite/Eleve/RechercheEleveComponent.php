<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Enums\EtudiantLimit;
use App\Models\Eleve;
use App\Models\Etudiant;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Livewire\WithPagination;

class RechercheEleveComponent extends Component
{
    use AuthorizesRequests, WithPagination;
    use LivewireAlert;

    public string $search = '';

    public function mount(): void
    {
        $this->authorize('viewAny', Eleve::class);
    }

    public function updatedSearch($value): void
    {
        $this->search = $value;
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {

        return view('livewire.scolarite.eleves.recherche')
            ->layout(AdminLayout::class, [
                'title' => 'Eleves',
               /* 'breadcrumbs' => [
                    ['label' => __('Dashboard'), 'url' => route('')]
                ],*/
            ]);
    }

    public function search(): void
    {
        $this->alert('success', 'Recherche effectuée avec succès !');
    }

    public function getEtudiantsProperty(): ?Collection
    {
        if (!empty($this->search)) {
            return Eleve::with('inscriptions')
                ->where(function ($query) {
                    $query->where('matricule', 'like', '%' . $this->search . '%')
                        ->orWhere('nom', 'like', '%' . $this->search . '%');
                })->latest()
                ->take(10)
                ->get();
        }

        return null;
    }

    public function download($etudiant): void
    {
        $etudiant = Eleve::find($etudiant['id']);
        if ($etudiant->qrCodeImageExists()) {
            $this->alert('error', 'This student QR Code exists !');
        } else {
            $etudiant->storeQrCodeImage();
            $this->alert('success', 'Téléchargement effectué avec succès !');
        }

    }

    private function generateImageZip()
    {

    }
}
