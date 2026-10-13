<?php

namespace App\Http\Livewire\Scolarite\Inscription;

use App\Enums\MediaType;
use App\Models\Annee;
use App\Models\Option;
use App\Models\Inscription;
use App\Traits\TopMenuPreview;
use App\Traits\WithFileUploads;
use App\View\Components\AdminLayout;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class InscriptionEditComponent extends Component
{
    use TopMenuPreview;
    use WithFileUploads;
    use LivewireAlert;

    public $bordereau;
    public $piece;
    public $fiche;

    public $hasBordereau = false;
    public $hasPiece = false;
    public $hasFiche = false;

    public $annee_courante;

    public $admission;
    public $etudiant;
    public $diplome;

    public $facultes = [];
    public $filieres = [];
    public $promotions = [];

    public $facultes2 = [];
    public $filieres2 = [];
    public $promotions2 = [];

    public $faculte_id = -1;
    public $filiere_id = -1;

    public $faculte2_id = -1;
    public $filiere2_id = -1;
    protected $messages = [
    ];

    public function mount(Inscription $admission)
    {
        // dd($admission->etudiant);
        $this->annee_courante = Annee::where('encours', true)->first();

        $this->admission = $admission;
        $this->etudiant = $this->admission->etudiant;
        $this->diplome = $this->etudiant->diplome;

        $this->filiere_id = $this->admission->promotion->filiere_id;
        $this->faculte_id = $this->admission->promotion->filiere->faculte_id;
        $this->facultes = Option::orderBy('nom')->get();
        if ($this->faculte_id > 0) {
            $faculte = Option::find($this->faculte_id);
            $this->filieres = $faculte->filieres;
            if (count($this->filieres) > 0) {
                $filiere = $this->filieres[0];
                $this->filiere_id = $filiere->id;
                $this->promotions = $filiere->promotions;
                if (count($this->promotions) > 0) {
                    $this->admission->promotion_id = $this->admission->promotion_id ?? $this->promotions[0]->id;
                } else {
                    $this->admission->promotion_id = -1;
                }
            } else {
                $this->filiere_id = -1;
                $this->promotions = [];
                $this->admission->promotion_id = -1;
            }
        } else {
            $this->filieres = [];
            $this->filiere_id = -1;
            $this->promotions = [];
            $this->admission->promotion_id = -1;
        }

        $this->filiere2_id = $this->admission->promotion2->filiere_id ?? -1;
        $this->faculte2_id = $this->admission->promotion2->filiere->faculte_id ?? -1;
        $this->facultes2 = Option::orderBy('nom')->get();
        if ($this->faculte2_id > 0) {
            $faculte = Option::find($this->faculte_id);
            $this->filieres2 = $faculte->filieres;
            if (count($this->filieres2) > 0) {
                $filiere = $this->filieres2[0];
                $this->filiere2_id = $filiere->id;
                $this->promotions2 = $filiere->promotions;
                if (count($this->promotions2) > 0) {
                    $this->admission->promotion2_id = $this->admission->promotion2_id ?? $this->promotions2[0]->id;
                } else {
                    $this->admission->promotion2_id = -1;
                }
            } else {
                $this->filiere2_id = -1;
                $this->promotions2 = [];
                $this->admission->promotion2_id = -1;
            }
        } else {
            $this->filieres2 = [];
            $this->filiere2_id = -1;
            $this->promotions2 = [];
            $this->admission->promotion2_id = -1;
        }

        $this->checkAvailabilityOfMedia();
    }

    private function checkAvailabilityOfMedia()
    {
        $media = $this->etudiant->media;
        foreach ($media as $medium) {
            if (!$this->hasBordereau) $this->hasBordereau = $medium->custom_property == MediaType::bordereaux;
            if (!$this->hasPiece) $this->hasPiece = $medium->custom_property == MediaType::diplome;
            if (!$this->hasFiche) $this->hasFiche = $medium->custom_property == MediaType::fiche_inscription;
        }
    }

    public function submit()
    {
        $this->validate();
        $done = $this->admission->save();
        if ($done) $done = $this->etudiant->save();
        if ($done) $done = $this->diplome->save();
        if ($done) {
            $this->uploadDocuments();
            $this->flash('success', "Admission modifiée avec succès !", [], route('scolarite.admissions.index'));

        } else {
            $this->alert('error', "Echec de modification de l'admission !");
        }
    }

    public function uploadDocuments()
    {
        if ($this->bordereau)
            $this->upload(file: $this->bordereau, entity: $this->etudiant, collection_name: MediaType::bordereaux);

        if ($this->piece)
            $this->upload(file: $this->piece, entity: $this->etudiant, collection_name: MediaType::diplome);

        if ($this->fiche)
            $this->upload(file: $this->fiche, entity: $this->etudiant, collection_name: MediaType::fiche_inscription);
    }

    public function render()
    {
        return view('livewire.scolarite.admission-academique.edit')
            ->layout(AdminLayout::class, ['title' => "Modification d'admission"]);
    }

    public function changeFaculte()
    {
        if ($this->faculte_id > 0) {
            $faculte = Option::find($this->faculte_id);
            $this->filieres = $faculte->filieres;
            if (count($this->filieres) > 0) {
                $filiere = $this->filieres[0];
                $this->filiere_id = $filiere->id;
                $this->promotions = $filiere->promotions;
                if (count($this->promotions) > 0) {
                    $this->admission->promotion_id = $this->promotions[0]->id;
                } else {
                    $this->admission->promotion_id = -1;
                    $this->admission->promotion2_id = -1;
                }
            } else {
                $this->filiere_id = -1;
                $this->promotions = [];
                $this->admission->promotion_id = -1;

                $this->filiere2_id = -1;
                $this->promotions2 = [];
                $this->admission->promotion2_id = -1;
            }
        } else {
            $this->filieres = [];
            $this->filiere_id = -1;
            $this->promotions = [];
            $this->admission->promotion_id = -1;

            $this->filieres2 = [];
            $this->filiere2_id = -1;
            $this->promotions2 = [];
            $this->admission->promotion2_id = -1;
        }
    }

    public function changeFiliere()
    {
        if ($this->filiere_id > 0) {
            $filiere = Option::find($this->filiere_id);
            $this->promotions = $filiere->promotions;
            if (count($this->promotions) > 0) {
                $this->admission->promotion_id = $this->promotions[0]->id;
            } else {
                $this->admission->promotion_id = -1;
                $this->admission->promotion2_id = -1;
            }
        } else {
            $this->promotions = [];
            $this->admission->promotion_id = -1;

            $this->promotions2 = [];
            $this->admission->promotion2_id = -1;
        }
    }

    public function changeFaculte2()
    {
        if ($this->faculte2_id > 0) {
            $faculte = Option::find($this->faculte2_id);
            $this->filieres2 = $faculte->filieres;
            if (count($this->filieres2) > 0) {
                $filiere = $this->filieres2[0];
                $this->filiere2_id = $filiere->id;
                $this->promotions2 = $filiere->promotions;
                if (count($this->promotions2) > 0) {
                    $this->admission->promotion2_id = $this->promotions2[0]->id;
                } else {
                    $this->admission->promotion2_id = -1;
                }
            } else {
                $this->filiere2_id = -1;
                $this->promotions2 = [];
                $this->admission->promotion2_id = -1;
            }
        } else {
            $this->filieres2 = [];
            $this->filiere2_id = -1;
            $this->promotions2 = [];
            $this->admission->promotion2_id = -1;
        }
    }

    public function changeFiliere2()
    {
        if ($this->filiere2_id > 0) {
            $filiere = Option::find($this->filiere2_id);
            $this->promotions2 = $filiere->promotions;
            if (count($this->promotions2) > 0) {
                $this->admission->promotion2_id = $this->promotions2[0]->id;
            } else {
                $this->admission->promotion2_id = -1;
            }
        } else {
            $this->promotions2 = [];
            $this->admission->promotion2_id = -1;
        }
    }

    protected function rules()
    {
        return [
            'etudiant.nom' => 'required',
            'etudiant.lieu_naissance' => 'nullable|string',
            'etudiant.date_naissance' => 'required|date',
            'etudiant.sexe' => 'string|nullable',
            'etudiant.etat_civil' => 'nullable',
            'etudiant.telephone' => ['nullable', Rule::unique('etudiants', 'telephone')->ignore($this->etudiant->id),],
            'etudiant.email' => ['required', Rule::unique('etudiants', 'email')->ignore($this->etudiant->id),],
            'etudiant.adresse' => 'nullable|string',
            'etudiant.pere' => 'nullable|string',
            'etudiant.mere' => 'nullable|string',
            'etudiant.tuteur' => 'nullable|string',
            'etudiant.origine' => 'nullable|string',
            'etudiant.contact_urgence' => 'nullable|string',
            'etudiant.adresse_urgence' => 'nullable|string',
            'diplome.numero' => 'nullable',
            'diplome.pourcentage' => 'nullable|numeric',
            'diplome.section' => 'nullable|string',
            'diplome.option' => 'nullable|string',
            'diplome.date_delivrance' => 'nullable',
            'diplome.ecole' => 'nullable|string',
            'diplome.code_ecole' => 'nullable|string',
            'diplome.province_ecole' => 'nullable|string',
            'admission.status' => 'nullable',
            'filiere_id' => 'required|numeric|min:1|not_in:0',
            'admission.promotion_id' => 'required|numeric|min:1|not_in:0',
            'faculte_id' => 'required|numeric|min:1|not_in:0',
            'admission.promotion2_id' => 'nullable|numeric|min:1|not_in:0',

            'bordereau' => 'nullable|mimes:pdf|max:3000',
            'piece' => 'nullable|mimes:pdf|max:3000',
            'fiche' => 'nullable|mimes:pdf|max:3000',
        ];
    }
}
