<?php

namespace App\Http\Livewire\Scolarite\Classe\Cours;

use App\Models\CoursEnseignant;
use App\Traits\HasLivewireAlert;
use App\Traits\TopMenuPreview;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class EditModal extends Component
{
    use TopMenuPreview;
    use HasLivewireAlert;

    public CoursEnseignant $cours_enseignant;


    public function mount(CoursEnseignant $coursEnseignant)
    {
        $this->cours_enseignant = $coursEnseignant;
    }


    public function submit()
    {
        $this->cours_enseignant->save();
        $this->refreshData();
        $this->success("Cours enseignant modifié avec succès");
        $this->emit('hideModal');
    }

    public function refreshData()
    {
        $this->emit('refreshData',);
    }


    // ajouter un cours

    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.classes.cours.edit-modal');
    }

    // function rules

    public function rules(): array
    {
        return [
            'cours_enseignant.enseignant_id' => 'required|exists:enseignants,id',
        ];
    }


}
