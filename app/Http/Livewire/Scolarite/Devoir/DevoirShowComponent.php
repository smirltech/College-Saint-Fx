<?php

namespace App\Http\Livewire\Scolarite\Devoir;


use App\Enums\MediaType;
use App\Http\Livewire\BaseComponent;
use App\Models\Cours;
use App\Models\Devoir;
use App\Models\DevoirReponse;
use App\Models\Eleve;
use App\Traits\CanDeleteMedia;
use App\Traits\HasLivewireAlert;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use JetBrains\PhpStorm\NoReturn;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;
use Str;

class DevoirShowComponent extends BaseComponent
{

    use HasLivewireAlert, WithFileUploads, CanDeleteMedia;

    public Devoir $devoir;
    public Cours $cours;
    public TemporaryUploadedFile|string|null $document = null;
    public $documents = [];
    public ?string $matricule = '';
    public ?Eleve $eleve;
    public DevoirReponse $devoir_reponse;
    protected $messages = [
        'document.max' => 'Le fichier ne doit pas dépasser 2Mo',
    ];

    #[NoReturn] public function submit()
    {
        $this->validate();

        $this->eleve = Eleve::where('matricule', $this->matricule)->first();

        if ($this->eleve) {
            $this->devoir_reponse->devoir_id = $this->devoir->id;
            $this->devoir_reponse->eleve_id = $this->eleve->id;

            $this->devoir_reponse->save();

            if ($this->document) {
                $this->devoir_reponse->addMedia(file: $this->document, collection_name: MediaType::document->value);
            }
            //$this->refreshData();
            $this->flash('success', 'Réponse envoyée avec succès', [], route('scolarite.devoirs.index'));
        } else {
            $this->alert('warning', "Cet élève n'existe pas !");
        }
    }

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.devoirs.show');
    }


    // delete media

    /**
     * @throws AuthorizationException
     */
    public function mount(Devoir $devoir)
    {
        $this->authorize('view', $devoir);
        $this->devoir = $devoir;
        $this->cours = $this->devoir->cours;
        $this->devoir_reponse = new DevoirReponse();
        $this->updatedMatricule();
    }

    public function updatedMatricule()
    {
        if (Str::length($this->matricule) == 10) {
            $this->validate([
                'matricule' => ['nullable', 'string', 'exists:eleves,matricule'],
            ]);
            $this->eleve = Eleve::whereHas('inscriptions', function ($query) {
                $query->where('classe_id', $this->devoir->classe_id)
                    ->where('annee_id', $this->devoir->annee_id);
            })->where('matricule', $this->matricule)->first();

            if (!$this->eleve) {
                $this->warning("L'élève n'est pas actuellement inscrit dans cette classe");
            }
        } else {
            $this->validate([
                // je mets ici nullable et je garde requiered du cote forumalire
                'matricule' => ['nullable', 'string', 'digits:10']
            ]);
            $this->eleve = null;
        }
    }

    protected function rules(): array
    {
        return [
            'devoir_reponse.contenu' => ['required', 'string'],
            'document' => ['required', 'file', 'mimes:pdf,jpg,jpeg,png', 'max:2048'],
        ];
    }

    // update matricule

    private function refreshData(): void
    {
        $this->devoir->refresh();
    }


}
