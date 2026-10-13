<?php

namespace App\Http\Livewire\Scolarite\Enseignant;

use App\Http\Livewire\BaseComponent;
use App\Models\Enseignant;
use App\Models\Section;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use JetBrains\PhpStorm\NoReturn;

class EnseignantEditComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public Enseignant $enseignant;
    public Collection $sections;
    protected $messages = [
        'enseignant.nom.required' => 'Le nom est obligatoire',
        'enseignant.nom.unique' => 'Le nom existe déjà',
        'enseignant.email.required' => 'L\'email est obligatoire',
        'enseignant.email.unique' => 'L\'email existe déjà',
        'enseignant.telephone.required' => 'Le téléphone est obligatoire',
        'enseignant.telephone.unique' => 'Le téléphone existe déjà',
        'enseignant.section_id.required' => 'La section est requise',
        'enseignant.lieu_naissance.required' => 'Le lieu de naissance est obligatoire',
        'enseignant.date_naissance.required' => 'La date de naissance est obligatoire',
    ];

    #[NoReturn] public function submit()
    {
        $this->validate();


        $this->enseignant->save();

        $this->flash('success', 'Enseignant ajoutée avec succès', [], route('scolarite.enseignants.index'));
    }

    public function mount(Enseignant $enseignant)
    {
        $this->authorize("update", $enseignant);
        $this->enseignant = $enseignant;
        $this->sections = Section::all();
    }

    public function render()
    {

        $data = ['title' => 'Modification d\'un enseignant'];
        return view('livewire.scolarite.enseingnants.edit', $data)
            ->layout(AdminLayout::class, $data);
    }

    protected function rules(): array
    {
        return [
            'enseignant.nom' => 'required|unique:enseignants,nom,' . $this->enseignant->id,
            'enseignant.email' => 'required|unique:enseignants,email,' . $this->enseignant->id,
            'enseignant.telephone' => 'required|unique:enseignants,telephone,' . $this->enseignant->id,
            'enseignant.section_id' => 'required',
            'enseignant.sexe' => 'required',
            'enseignant.date_naissance' => 'required|date|before:today-18 years',
            'enseignant.lieu_naissance' => 'required',
            'enseignant.adresse' => 'required',
        ];
    }


}
