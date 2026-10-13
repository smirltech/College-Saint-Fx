<?php

namespace App\Http\Livewire\Bibliotheque\Tags;

use App\Http\Livewire\BaseComponent;
use App\Models\Tag;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;

class TagsIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public Collection $etiquettes;

    protected $listeners = ['refresh' => 'refreshData'];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize("viewAny", Tag::class);
        $this->etiquettes = Tag::orderBy('name->fr')->get();
        $this->etiquette = new Tag();

    }

    public function render(): Factory|View|Application
    {

        return view('livewire.bibliotheque.tags.index')
            ->with(['title' => "Liste d'Étiquettes"]);
    }

    public function deleteEtiquette($id): void
    {

        if (Tag::destroy($id)) {
            $this->emit('refresh');
            $this->success("Étiquette supprimée avec succès !");
        } else {
            $this->warning("Étiquette n'a pas été supprimée, il y a des éléments attachés !");
        }
    }

    public function refreshData(): void
    {
        $this->etiquettes = Tag::orderBy('name->fr')->get();
    }

}
