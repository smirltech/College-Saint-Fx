<?php

namespace App\Http\Livewire\Finance\Perception;

use App\Enums\Devise;
use App\Imports\PerceptionImport;
use App\Models\Annee;
use App\Models\Frais;
use App\Traits\HasLivewireAlert;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use Illuminate\View\View;
use Livewire\Component;
use Livewire\TemporaryUploadedFile;
use Livewire\WithFileUploads;


class ImportPerceptionComponent extends Component
{
    use HasLivewireAlert, WithFileUploads;

    public Collection $frais;
    public ?int $frais_id = null;
    public ?int $annee_id = null;
    public null|TemporaryUploadedFile|string $file = null;

    protected $listeners = ['confirmed', 'cancelled'];
    private ?Frais $selectedFrais = null;
    public Collection $annees;
    public ?Frais $fee = null;
    public ?string $custom_property = null;
    public ?Devise $devise = null;

    public function mount(): void
    {
        $this->frais = Frais::orderBy('nom')->get();
        $this->annees = Annee::all();

        $this->annee_id = Annee::id();
    }


    public function updatedFraisId($value): void
    {
        $this->fee = Frais::find($value);
        $this->devise = $this->fee->devise;
    }


    public function getTitleProperty(): string
    {

        return "Import Perceptions";
    }

    public function render(): Factory|\Illuminate\Foundation\Application|\Illuminate\Contracts\View\View|View|Application
    {
        return view('livewire.finance.perceptions.import-perceptions');
    }

    public function submit(): void
    {

        $this->validate();
        $frais = Frais::find($this->frais_id);
        $annee = Annee::find($this->annee_id);

        $this->confirm("Voulez-vous vraiment importer les perceptions pour le {$frais->nom} pour {$annee->nom}?",
            [
                'toast' => false,
                'position' => 'center',
                'showConfirmButton' => true,
                'cancelButtonText' => 'Annuler',
                'confirmButtonText' => 'Oui, importer',
                'onConfirmed' => 'confirmed',
                'onCancelled' => 'cancelled',
            ]);
    }

    public function confirmed(): void
    {
        try {
            $frais = Frais::find($this->frais_id);
            $annee = Annee::find($this->annee_id);

            DB::beginTransaction();
            PerceptionImport::build(frais: $frais, annee: $annee, devise: $frais->devise)
                ->import($this->file->getRealPath());
            DB::commit();

            $this->flashSuccess('Les perceptions ont été importées avec succès', URL::previous());
        } catch (Exception $e) {
            $this->error($e->getMessage());
            DB::rollBack();
        }
    }

    public function rules(): array
    {
        return [
            'file' => 'required|file',
            'devise' => 'required',
            'frais_id' => 'required|exists:frais,id'
        ];
    }


}
