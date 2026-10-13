<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Enums\DevoirStatus;
use App\Enums\MediaType;
use App\Http\Livewire\BaseComponent;
use App\Models\Classe;
use App\Models\Devoir;
use App\Traits\CanDeleteMedia;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Validation\Rule;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;

class DevoirEditComponent extends BaseComponent
{
    use TopMenuPreview;

    use HasLivewireAlert, WithFileUploads, CanDeleteMedia;

    public Devoir $devoir;
    public Collection|array $cours = [];
    public Collection $classes;
    public TemporaryUploadedFile|string|null $document = null;
    public $documents = [];
    public ?Collection $reponses;

    protected $listeners = [
        'deleteConfirmed',
    ];


    protected $messages = [
        'devoir.titre.required' => 'Le titre est obligatoire',
        'devoir.contenu.required' => 'Le contenu est obligatoire',
        'devoir.echeance.required' => 'L\'échéance est obligatoire',
        'devoir.cours_id.required' => 'Le cours est obligatoire',
        'devoir.classes_id.required' => 'La classe est obligatoire',
        'document.max' => 'Le fichier ne doit pas dépasser 2Mo',
    ];

    public function submit()
    {
        $this->validate();

        $this->devoir->save();
        if ($this->document) {
            $this->devoir->addMedia(file: $this->document, collection_name: MediaType::document->value);
            $this->document = null;
        }
        $this->refreshData();
        $this->alert('success', 'Cours modifiée avec succès');
    }

    private function refreshData(): void
    {
        $this->devoir->refresh();
        $this->reponses = $this->devoir->reponses;
    }


    public function updatedDevoirClasseId($value): void
    {
        $classe = Classe::find($value);
        $this->cours = $classe->cours;
    }

    // delete media

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.devoirs.edit');
    }

    public function mount(Devoir $devoir)
    {
        $this->authorize('update', $devoir);
        $this->devoir = $devoir;
        $this->classes = Classe::has('cours')->get();
        $this->reponses = $devoir->reponses;
        $this->cours = $this->devoir->classe->cours;
    }

    // deleteDevoir

    public function deleteDevoir(): void
    {
// has reponses
        if ($this->devoir->reponses->count() > 0) {
            $this->alert('error', 'Impossible de supprimer ce devoir car il a des réponses');
            return;
        }
        // alert confirm before delete
        $this->confirm('Voulez-vous vraiment supprimer ce devoir ?', [
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => "Oui, supprimer",
            'cancelButtonText' => "Annuler",
            'onConfirmed' => 'deleteConfirmed',
        ]);
    }

    public function deleteConfirmed(): void
    {
        try {
            $this->devoir->delete();
            $this->flash(message: 'Devoir supprimé avec succès', redirect: route('scolarite.devoirs.index'));
        } catch (Exception $e) {
            $this->error($e->getMessage(), 'Une erreur s\'est produite lors de la suppression du devoir');
        }
    }


    protected function rules(): array
    {
        return [
            'devoir.titre' => ['required', 'string'],
            'devoir.contenu' => ['required', 'string'],
            'devoir.classe_id' => ['required', 'integer'],
            'devoir.cours_id' => ['required', 'integer'],
            'devoir.echeance' => ['required', 'date'],
            'devoir.status' => ['required', Rule::enum(DevoirStatus::class)],
            'document' => ['nullable', 'file', 'mimes:pdf', 'max:2048'],
        ];
    }

}
