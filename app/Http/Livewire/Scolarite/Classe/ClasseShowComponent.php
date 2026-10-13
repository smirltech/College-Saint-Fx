<?php

namespace App\Http\Livewire\Scolarite\Classe;

use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseEnseignant;
use App\Models\Cours;
use App\Models\CoursEnseignant;
use App\Models\Enseignant;
use App\Models\Option;
use App\Models\Section;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;

class ClasseShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public Classe $classe;
    public ?string $parent = "";
    public ?string $parent_url = "";
    public ?Collection $inscriptions;
    public Collection $cours;
    public ?CoursEnseignant $cours_enseignant;
    public ?ClasseEnseignant $classe_enseignant;
    public Collection $enseignants;

    protected $listeners = ['refreshData', 'refresh' => 'refreshData'];

    public function mount(Classe $classe)
    {
        $this->authorize('view', $classe);
        $this->cours_enseignant = new CoursEnseignant();
        $this->classe_enseignant = new ClasseEnseignant();

        $this->classe = $classe;
        $this->cours = $classe->cours;
        $this->enseignants = $classe->enseignants;
        $this->inscriptions = $this->classe->inscriptions;
        // $this->admissions = $this->promotion->admissions;

        $classable = $classe->parent;
       if ($classable instanceof Option) {
            $this->parent_url = "/scolarite/options/$classe->parent->id";
            $this->parent = "Option";
        } else if ($classable instanceof Section) {
            $this->parent_url = "/scolarite/sections/$classe->paerent->id";
            $this->parent = "Section";
        }
    }


    // hydrate

    public function addCours()
    {
        if (!$this->classe->primaire() && $this->cours_enseignant->cours_id == null && count(Cours::classe($this->classe)->get()) > 0) {
            $this->cours_enseignant->cours_id = Cours::classe($this->classe)->get()->first()->id;
        }

        if (!$this->classe->primaire() && $this->cours_enseignant->enseignant_id == null && count(Enseignant::classe($this->classe)->get()) > 0) {
            $this->cours_enseignant->enseignant_id = Enseignant::classe($this->classe)->get()->first()->id;
        }
        $this->validate([
            'cours_enseignant.cours_id' => [
                'required',
                Rule::unique('cours_enseignants', 'cours_id')->where(function ($query) {
                    return $query->where('classe_id', $this->classe->id)
                        ->where('annee_id', Annee::encours()->id);
                })],
            'cours_enseignant.enseignant_id' => Rule::requiredIf(!$this->classe->primaire()), // si la classe n'est pas primaire
        ]);

        $this->cours_enseignant->classe_id = $this->classe->id;
        $this->cours_enseignant->save();

        $this->dispatchBrowserEvent('closeModal', ['modal' => 'add-cours-modal']);
        $this->refreshData();
    }

    public function refreshData()
    {
        $this->classe->refresh();
        $this->cours = $this->classe->cours;
        $this->enseignants = $this->classe->enseignants;
    }


    // ajouter un cours

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.classes.show')
            ->layout(AdminLayout::class, ['title' => 'Détail sur la classe']);
    }

    // function rules

    public function rules()
    {
        return [
            'cours_enseignant.cours_id' => 'required|exists:cours,id',
            'cours_enseignant.enseignant_id' => 'required|exists:enseignants,id',
            'classe_enseignant.enseignant_id' => 'required|exists:enseignants,id',
        ];
    }

    // deleteCours
    public function deleteCours(CoursEnseignant $cours_enseignant)
    {
        try {
            $cours_enseignant->delete();
            $this->refreshData();

            $this->alert('success', 'Le cours a été supprimé avec succès');
        } catch (Exception $e) {
            $this->error(local: $e->getMessage(), production: "Impossible de supprimer ce cours");
        }
    }
}
