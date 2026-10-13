<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Enums\MediaType;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Devoir;
use App\Traits\CanDeleteModel;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Http\UploadedFile;
use Livewire\Component;
use Livewire\WithFileUploads;

class DevoirCreateComponent extends Component
{
    use TopMenuPreview;

    use HasLivewireAlert, WithFileUploads, CanDeleteModel;

    public Devoir $devoir;
    public Collection|array $cours = [];
    public Collection $classes;
    public UploadedFile|string|null $document = null;

    protected $messages = [
        'devoir.titre.required' => 'Le titre est obligatoire',
        'devoir.contenu.required' => 'Le contenu est obligatoire',
        'devoir.echeance.required' => 'L\'échéance est obligatoire',
        'devoir.cours_id.required' => 'Le cours est obligatoire',
        'devoir.classe_id.required' => 'La classe est obligatoire',
        'document.max' => 'Le fichier ne doit pas dépasser 2Mo',
    ];

    public function submit(): void
    {
        $this->devoir->annee_id = Annee::id();
        $this->validate();

        $this->devoir->save();
        if ($this->document) {
            $this->devoir->addMedia(file: $this->document, collection_name: MediaType::document->value);
        }

        $this->flash('success', 'Devoir créé avec succès', [], route('scolarite.devoirs.index'));
    }

    public function render(): Factory|View|Application
    {

        return view('livewire.scolarite.devoirs.create');
    }

    public function mount()
    {
        $this->devoir = new Devoir();
        $this->classes = Classe::has('cours')->get();
    }

    // delete media

    public function updatedDevoirClasseId($value): void
    {
        $classe = Classe::find($value);
        $this->cours = $classe->cours;
    }

    // on classe change

    protected function rules(): array
    {
        return [
            'devoir.titre' => ['required', 'string'],
            'devoir.contenu' => ['required', 'string'],
            'devoir.classe_id' => ['required', 'integer'],
            'devoir.cours_id' => ['required', 'integer'],
            'devoir.echeance' => ['required', 'date'],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }


}
