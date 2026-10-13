<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Http\Livewire\BaseComponent;
use App\Models\Lecture;
use App\Models\Ouvrage;
use App\Models\OuvrageAuteur;
use App\Models\Rayon;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Auth;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;

class OuvrageShowComponent extends BaseComponent
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public Ouvrage $ouvrage;
    public OuvrageAuteur $ouvrage_auteur;
    public $auteurs = [];


    /**
     * @throws AuthorizationException
     */
    public function mount(Ouvrage $ouvrage): void
    {
        $this->authorize("view", $ouvrage);
        $this->ouvrage = $ouvrage;
        $this->ouvrage->lectures = $ouvrage->lectures;
        // dd($this->ouvrage);
    }

    public function render(): Factory|View|Application
    {
        $this->loadData();
        return view('livewire.bibliotheque.ouvrages.show')
            ->layout(AdminLayout::class, ['title' => "Détail sur l'ouvrage"]);
    }

    public function loadData(): void
    {
        $this->categories = Rayon::orderBy('nom', 'ASC')->get();
    }

    public function updateOuvrage(): void
    {
        $this->validate();

        $done = $this->ouvrage->save();
        if ($done) {
            $this->onModalClosed('update-ouvrage-modal');
            $this->alert('success', "Ouvrage modifié avec succès !");
        } else {
            $this->alert('warning', "Échec de modification d'ouvrage !");
        }
        $this->category->refresh();
    }



    // Auteurs


    // Etiquettes

    public function addLecture(): void
    {
        $lecture = new Lecture();
        $lecture->user_id = Auth::id() ?? null;
        $lecture->ouvrage_id = $this->ouvrage->id;

        try {
            $done = $lecture->save();
            $this->ouvrage->refresh();
        } catch (Exception $exception) {
            //  dd($exception);
        }

    }

}
