<?php

namespace App\Http\Livewire\Scolarite\Classe;


use App\Http\Livewire\BaseComponent;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\ClasseEnseignant;
use App\Models\Enseignant;
use App\Models\Option;
use App\Models\Section;
use App\Traits\CanHandleClasseCode;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use phpDocumentor\Reflection\Types\Nullable;

class ClasseEditComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;
    use CanHandleClasseCode;


    public Classe $classe;
    public Collection $optionsx;
    public Collection $sections;
    public Collection $enseignants;
    public ?string $enseignant_id=null;
    public ?string $section_id = null;
    public ?string $option_id = null;
    public ?string $type = null;


    public function mount(Classe $classe): void
    {
        $this->classe = $classe;

        if ($classe->exists) {
            $this->authorize("update", $classe);

            $this->option_id = $this->classe->option_id;
            $this->section_id = $this->classe->section_id;
            $this->enseignant_id = $this->classe->enseignant_id;
        } else {
            $this->authorize("create", Classe::class);
        }

        $this->optionsx = Option::all();
        $this->sections = Section::all();
        $this->enseignants = Enseignant::all();


    }


    public function submit(): void
    {


        $this->validate();

        $this->classe->option_id = $this->option_id;
        $this->classe->section_id = $this->section_id;
        $this->classe->enseignant_id = $this->enseignant_id;


        $this->classe->save();

        $this->flashSuccess('Classe enregistrée avec succès', route('scolarite.classes.index'));

    }

    public function render()
    {
        return view('livewire.scolarite.classes.edit')
            ->layout(AdminLayout::class, ['title' => 'Modification de la classe']);
    }

    public function updatedClasseNiveau(): void
    {
        $this->setCode();
    }

    public function updatedSectionId(): void
    {
        $this->setCode();
    }

    /*  public function updatedClasseSectionId($value): void
      {
          $this->classe->section_id = $value;
          $this->setCode();
      }*/

    public function setCode(): void
    {
        $optionSection = Option::find($this->option_id) ?? Section::find($this->section_id);
//        $this->classe->code = "{$this->classe->niveau?->value}{$optionSection->code}{$this->type ?? ''}";
        $this->classe->code = $this->classe->niveau?->value
            . ($optionSection?->code ?? '')
            . ($this->type ?? '');
    }

    public function updatedOptionId(): void

    {
        $this->setCode();
    }

    public function updatedType(): void
    {
        $this->setCode();
    }


    protected function rules(): array
    {
        return [
            'classe.niveau' => "required",
            'classe.code' => 'required|unique:classes,code,' . $this->classe->id,
            'section_id' => 'required',
            'option_id' => 'nullable',
            'enseignant_id' => 'nullable',
            'type' => [
                'nullable',
                Rule::in(['A', 'B', 'C', 'D', 'E', 'F', 'G']),
            ],
        ];
    }

}
