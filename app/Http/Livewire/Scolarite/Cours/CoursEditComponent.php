<?php

namespace App\Http\Livewire\Scolarite\Cours;


use App\Http\Livewire\BaseComponent;
use App\Models\Cours;
use App\Models\Section;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class CoursEditComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

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

        $this->alert('success', 'Cours modifiée avec succès');
    }


    public function mount(Cours $cours)
    {
        $this->authorize('update', $cours);
        $this->cours = $cours;
        $this->sections = Section::all();
    }


    public function render()
    {
        return view('livewire.scolarite.cours.edit')
            ->layout(AdminLayout::class, ['title' => 'Ajout de classe']);
    }


    protected function rules(): array
    {
        return [
            'cours.nom' => ['required', Rule::unique('cours')->where(fn($query) => $query->where('section_id', $this->cours->section_id)
                ->where('nom', $this->cours->nom))
                ->ignore($this->cours->id)],
            'cours.description' => 'required',
            'cours.section_id' => 'required'
        ];
    }
}
