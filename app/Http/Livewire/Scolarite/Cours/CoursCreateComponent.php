<?php

namespace App\Http\Livewire\Scolarite\Cours;

use App\Http\Livewire\BaseComponent;
use App\Models\Cours;
use App\Models\Section;
use App\Traits\CanHandleClasseCode;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CoursCreateComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;
    use CanHandleClasseCode;

    public Cours $cours;
    public Collection $sections;
    protected $messages = [
        'cours.nom.required' => 'Le nom est obligatoire',
        'cours.nom.unique' => 'Le nom existe déjà',
        'cours.description.required' => 'La description est requise',
        'cours.section_id.required' => 'La section est requise'
    ];

    public function submit()
    {
        $this->validate();

        $this->cours->save();

        $this->flash('success', 'Cours ajoutée avec succès', [], route('scolarite.cours.index'));
    }

    public function mount()
    {
        $this->authorize('create', Cours::class);
        $this->cours = new Cours();
        $this->sections = Section::all();
    }

    public function render()
    {

        return view('livewire.scolarite.cours.create')
            ->layout(AdminLayout::class, ['title' => 'Ajout de classe']);
    }

    protected function rules(): array
    {
        return [
            'cours.nom' => ['required', Rule::unique('cours')->where(fn($query) => $query->where('section_id', $this->cours->section_id)
                ->where('nom', $this->cours->nom))],
            'cours.description' => 'required',
            'cours.section_id' => 'required'

        ];
    }


}
