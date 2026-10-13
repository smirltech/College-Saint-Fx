<?php

namespace App\Http\Livewire\Scolarite\Enseignant;

use App\Http\Livewire\BaseComponent;
use App\Models\Enseignant;
use App\Models\Section;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use JetBrains\PhpStorm\NoReturn;

class EnseignantCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public Enseignant $enseignant;
    public Collection $sections;

    #[NoReturn] public function submit(): void
    {
        $this->validate();


        $this->enseignant->save();

        $this->flash('success', 'Enseignant ajoutée avec succès', [], route('scolarite.enseignants.index'));
    }

    public function mount(): void
    {
        $this->authorize("create", Enseignant::class);
        $this->enseignant = new Enseignant();
        $this->sections = Section::all();

        /* if (app()->isLocal()) {
             $this->enseignant->date_naissance = Date::create(1999, 1, 1)->format('Y-m-d');
             $this->enseignant->lieu_naissance = 'Yaound';
             $this->enseignant->sexe = Sexe::f;
             $this->enseignant->section_id = $this->sections->first()->id;
         }*/
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {

        $data = ['title' => 'Ajout d\'un enseignant'];
        return view('livewire.scolarite.enseingnants.create', $data)
            ->layout(AdminLayout::class, $data);
    }

    protected function rules(): array
    {
        return [
            'enseignant.nom' => 'required|unique:enseignants,nom',
            'enseignant.email' => 'nullable|unique:enseignants,email',
            'enseignant.telephone' => 'nullable|unique:enseignants,telephone',
            'enseignant.section_id' => 'required',
            'enseignant.sexe' => 'nullable',
            'enseignant.date_naissance' => 'nullable|date|before:today-18 years',
            'enseignant.lieu_naissance' => 'nullable',
            'enseignant.adresse' => 'nullable',
        ];
    }


}
