<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Enums\MediaType;
use App\Models\Auteur;
use App\Models\Ouvrage;
use App\Models\Rayon;
use App\Models\Tag;
use App\Traits\HasLivewireAlert;
use App\Traits\WithFileUploads;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Database\Eloquent\Collection;
use JetBrains\PhpStorm\NoReturn;
use Livewire\Component;

class OuvrageCreateComponent extends Component
{
    use HasLivewireAlert, WithFileUploads;

    public Collection $categories;
    public Collection $auteurs;
    public Collection $tags;
    public Ouvrage $ouvrage;
    public $ouvrage_pdf;
    public array $ouvrage_auteurs = [];
    public array $ouvrage_tags = [];
    public mixed $cover = null;
    protected $listeners = ['refresh' => '$refresh'];
    protected $rules = [
        'ouvrage.rayon_id' => 'required|exists:rayons,id',
        'ouvrage.titre' => 'required',
        'ouvrage.sous_titre' => 'nullable',
        'ouvrage.resume' => 'nullable',
        'ouvrage.edition' => 'nullable',
        'ouvrage.lieu' => 'nullable',
        'ouvrage.editeur' => 'nullable',
        'ouvrage.date' => 'nullable',
        'ouvrage.url' => 'nullable',
        'ouvrage_tags' => 'nullable|array',
        'ouvrage_auteurs' => 'nullable|array',
        'ouvrage_pdf' => 'nullable|mimes:pdf|max:10000',
        'ouvrage_cover' => 'nullable|image|max:10000',
    ];

    public function render(): Factory|View|Application
    {
        return view('livewire.bibliotheque.ouvrages.create')->with('title', 'Ajouter un ouvrage');
    }

    public function mount(Ouvrage $ouvrage): void
    {
        $this->ouvrage = $ouvrage;
        $this->categories = Rayon::orderBy('nom')->get();
        $this->tags = Tag::orderBy('name')->get();
        $this->auteurs = Auteur::all();

        $this->ouvrage_auteurs = $this->ouvrage->auteurs->pluck('id')->toArray();
        $this->ouvrage_tags = $this->ouvrage->tags->pluck('id')->toArray();
    }

    #[NoReturn] public function submit(): void
    {
        $id = $this->ouvrage->id;
        $this->ouvrage->save();

        $this->ouvrage->auteurs = $this->ouvrage_auteurs;
        $this->ouvrage->tags = $this->ouvrage_tags;
        $this->ouvrage->save();

        if ($this->ouvrage_pdf) {
            $this->ouvrage->deleteAllMedia(MediaType::document->value);
            $this->ouvrage->addMedia($this->ouvrage_pdf, MediaType::document->value);
            $this->reset('ouvrage_pdf');
        }

        if ($this->cover) {
            $this->ouvrage->deleteAllMedia('images');
            $this->ouvrage->addImage($this->cover);
            $this->reset('cover');
        }

        if ($id) {
            $this->success("Ouvrage modifié avec succès !");
        } else {
            $this->flashSuccess("Ouvrage ajouté avec succès !", route('bibliotheque.ouvrages.edit', $this->ouvrage->id));
        }

        $this->emit('refresh');
    }

    // deleteMedia() is a custom method
    public function deleteMedia($id): void
    {
        $this->ouvrage->media()->findOrFail($id)->delete();
        $this->success("Fichier supprimé avec succès !");
        $this->emit('refresh');
    }
}
