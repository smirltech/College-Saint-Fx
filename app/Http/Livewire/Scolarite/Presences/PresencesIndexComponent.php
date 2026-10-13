<?php

namespace App\Http\Livewire\Scolarite\Presences;

use App\Http\Livewire\BaseComponent;
use App\Models\Classe;
use App\Models\Eleve;
use App\Models\Section;
use App\Traits\FakeProfileImage;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\Auth;

class PresencesIndexComponent extends BaseComponent
{
    use TopMenuPreview, FakeProfileImage;

    public $eleves = [];

    public string $classe_id = '';
    public string $section_id = '';



    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->sections = Section::all();
        $this->classes = Classe::orderBy('code')->get();
    }


    public function render(): View|Factory|Application
    {

        return view('livewire.scolarite.presences.index')
            ->layout(AdminLayout::class, ['title' => 'Liste des présences']);
    }

}
