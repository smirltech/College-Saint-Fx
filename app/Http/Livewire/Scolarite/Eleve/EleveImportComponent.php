<?php

namespace App\Http\Livewire\Scolarite\Eleve;

use App\Http\Livewire\BaseComponent;
use App\Imports\InscriptionsImport;
use App\Models\Annee;
use App\Models\Classe;
use App\Models\Eleve;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Support\Facades\DB;
use Livewire\WithFileUploads;

class EleveImportComponent extends BaseComponent
{

    use WithFileUploads;

    public mixed $file = null;
    public string|null $annee_id = null;
    public ?string $classe_id = null;
    protected $listeners = ['confirmed' => 'confirmed'];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize('create', Eleve::class);
        $this->title = 'Impomrter la liste d\'élèves';
        $this->annees = Annee::all();
        $this->annee_id = Annee::id();
        $this->classes = Classe::all();
    }


    public function render(): Factory|View|Application
    {
        return view('livewire.scolarite.eleves.eleve-import-component')->layoutData(['title' => $this->title]);
    }

    // submit form

    /**
     * @throws Exception
     */
    public function submit(): void
    {
        try {
            DB::beginTransaction();
            InscriptionsImport::build(anneeId: $this->annee_id, classeId: $this->classe_id)->import($this->file->getRealPath());
            DB::commit();
            $this->flashSuccess('Liste des élèves importée avec succès', route('scolarite.eleves.index'));
            $this->emit('refresh');
        } catch (Exception $e) {
            DB::rollBack();
            $this->error($e->getMessage(), $e->getMessage());
        }
    }

    // con

    // confirmed submit
    /**
     * @throws Exception
     */

    // rules()
    public function rules(): array
    {
        return [
            'file' => 'required|mimes:xlsx',
            'annee_id' => 'required',
            //   'classe_id' => 'required'
        ];
    }

}
