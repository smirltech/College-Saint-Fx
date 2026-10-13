<?php
//
//namespace App\Http\Livewire\Finance\Rapports;
//
//
//use App\Models\Annee;
//use App\Models\Classe;
//use App\Models\Depense;
//use App\Models\Frais;
//use App\Models\Inscription;
//use App\Models\Perception;
//use App\Models\Revenu;
//use App\Models\Section;
//use App\Traits\TopMenuPreview;
//
//use App\Traits\WithPrintToPdf;
//use App\View\Components\AdminLayout;
//use Carbon\Carbon;
//use FontLib\TrueType\Collection;
//use Jantinnerezo\LivewireAlert\LivewireAlert;
//use Livewire\Component;
//
//class RapportInsolvablesComponent extends Component
//{
//    use TopMenuPreview;
//    use LivewireAlert;
//    use WithPrintToPdf;
//
//
//    public $frais = null;
//
//    public $date_from;
//    public $date_to;
//    public ?string $section_id = null;
//    public ?string $classe_id = null;
//    public ?int $frais_id = null;
//    public ?int $month = null;
//
//    public $revenuAuxiliaire = 0;
//    public $perception = 0;
//    public $depenses = 0;
//    public $depensesTypes = [];
//    public $annee_id;
//    public $anneeNom;
////    protected $rules = [
////        'date_from' => 'nullable',
////        'date_to' => 'nullable',
////    ];
//
////    public $classes = '';
////    public
//    private $annee;
//
////    public function mount(): void
////    {
////        $this->annee = Annee::encours();
////        $this->annee_id = $this->annee->id;
////        $this->anneeNom = $this->annee->nom;
////        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
////        $this->date_to = Carbon::now()->format('Y-m-d');
////        $this->classes = Classe::all();
////        $this->fraisOptions = Frais::all();
////        $this->sections = Section::all();
////
////        if (!$this->section_id) {
////            $this->section_id = $this->sections->first()?->id;
////        }
////
////        $this->updatedSectionId($this->section_id);
////
////    }
//
//    public function mount(): void
//    {
//        $this->annee = Annee::encours();
//        $this->annee_id = $this->annee->id;
//        $this->anneeNom = $this->annee->nom;
//
//        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
//        $this->date_to = Carbon::now()->format('Y-m-d');
//
//        $this->fraisOptions = Frais::all();
//
//        $this->sections = Section::all();
//
//        if (!$this->section_id) {
//            $this->section_id = $this->sections->first()?->id;
//        }
//
//        $this->updatedSectionId($this->section_id);
//    }
//
//    public function updatedSectionId($value)
//    {
//        $this->classe_id = null;
//
//        $this->classes = Classe::where('section_id', $value)
//            ->orderBy('niveau')
//            ->orderBy('code')
//            ->get()
//            ->mapWithKeys(function ($classe) {
//                return [
//                    $classe->id => $classe->niveau->label() . ' ' . $classe->code
//                ];
//            })
//            ->toArray();
//    }
//
//    public function render()
//    {
//        return view('livewire.finance.rapports.insolvables', ['annee' => $this->annee, 'title' => $this->title])
//            ->layout(AdminLayout::class, ['title' => $this->title]);
//    }
//
//
//    public function getTitleProperty(): string
//    {
//        return 'Insolvabes en ordre ' . now()->parse($this->date_from)->format('d-m-Y') . ' au ' . now()->parse($this->date_to)->format('d-m-Y');
//    }
//
//
//    public function getInscriptionsProperty(): string
//    {
//        return Inscription::when($this->section_id, function ($query) {
//            return $query->where('section_id', $this->section_id);
//        })->when($this->classe_id, function ($query) {
//            return $query->where('classe_id', $this->classe_id);
//        })->get();
//
//    }
//
//    public function getPerceptionsProperty(): \Illuminate\Database\Eloquent\Collection
//    {
//        return Perception::with('inscription')->when($this->section_id, function ($query) {
//            return $query->whereHas('inscription', function ($query) {
//                $query->whereHas('classe', function ($query) {
//                    $query->where('section_id', $this->section_id);
//                });
//            });
//        })->when($this->classe_id, function ($query) {
//            return $query->whereHas('inscription', function ($query) {
//                $query->where('classe_id', $this->classe_id);
//            });
//        })->when($this->frais_id, function ($query) {
//            return $query->where('frais_id', $this->frais_id);
//        })->when($this->month, function ($query) {
//            return $query->where('custom_property', 'like', '%' . $this->month . '%');
//        })->orderBy('inscription_id')->get();
//
//
//    }
//
//
//    public function getInsolvablesProperty(): \Illuminate\Database\Eloquent\Collection
//    {
//        return Inscription::whereNotIn('id', $this->perceptions->pluck('inscription_id'))->when($this->section_id, function ($query) {
//            return $query->whereHas('classe', function ($query) {
//                $query->where('section_id', $this->section_id);
//            });
//        })->when($this->classe_id, function ($query) {
//            return $query->where('classe_id', $this->classe_id);
//        })->get();
//    }
//
//
//    public function printIt(): \Symfony\Component\HttpFoundation\StreamedResponse
//    {
//        //$this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => '100%']);
//
//        return $this->printToPdf('livewire.finance.rapports.modals.insolvables-printable', $this->all(), $this->title . '.pdf');
//
//    }
//}


namespace App\Http\Livewire\Finance\Rapports;


use App\Models\Annee;
use App\Models\Classe;
use App\Models\Depense;
use App\Models\Frais;
use App\Models\Inscription;
use App\Models\Perception;
use App\Models\Revenu;
use App\Models\Section;
use App\Traits\TopMenuPreview;

use App\Traits\WithPrintToPdf;
use App\View\Components\AdminLayout;
use Carbon\Carbon;
use FontLib\TrueType\Collection;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class RapportInsolvablesComponent extends Component
{
    use TopMenuPreview;
    use LivewireAlert;
    use WithPrintToPdf;


    public $frais = null;

    public $date_from;
    public $date_to;
    public ?string $section_id = null;
    public ?string $classe_id = null;
    public ?int $frais_id = null;
    public ?int $month = null;

    public $revenuAuxiliaire = 0;
    public $perception = 0;
    public $depenses = 0;
    public $depensesTypes = [];
    public $annee_id;
    public $anneeNom;
    protected $rules = [
        'date_from' => 'nullable',
        'date_to' => 'nullable',
    ];
    private $annee;

    public function mount(): void
    {
        $this->annee = Annee::encours();
        $this->annee_id = $this->annee->id;
        $this->anneeNom = $this->annee->nom;
        $this->date_from = Carbon::now()->startOfMonth()->format('Y-m-d');
        $this->date_to = Carbon::now()->format('Y-m-d');
        $this->classes = Classe::all();
//            ->mapWithKeys(function ($classe) {
//                return [
//                    $classe->id => $classe->code . ' - ' . $classe->niveau->label()
//                        . ' - '
//                        . $classe->code
//                        . ' (' . $classe->section_id . ')'
//                ];
//            })
//            ->toArray();
        $this->fraisOptions = Frais::all();
        $this->sections = Section::all();

        if (!$this->section_id) {
            $this->section_id = $this->sections->first()?->id;
        }

    }

    public function render()
    {
        return view('livewire.finance.rapports.insolvables', ['annee' => $this->annee, 'title' => $this->title])
            ->layout(AdminLayout::class, ['title' => $this->title]);
    }


    public function getTitleProperty(): string
    {
        return 'Insolvabes en ordre ' . now()->parse($this->date_from)->format('d-m-Y') . ' au ' . now()->parse($this->date_to)->format('d-m-Y');
    }


    public function getInscriptionsProperty(): string
    {
        return Inscription::when($this->section_id, function ($query) {
            return $query->where('section_id', $this->section_id);
        })->when($this->classe_id, function ($query) {
            return $query->where('classe_id', $this->classe_id);
        })->get();

    }

    public function getPerceptionsProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return Perception::with('inscription')->when($this->section_id, function ($query) {
            return $query->whereHas('inscription', function ($query) {
                $query->whereHas('classe', function ($query) {
                    $query->where('section_id', $this->section_id);
                });
            });
        })->when($this->classe_id, function ($query) {
            return $query->whereHas('inscription', function ($query) {
                $query->where('classe_id', $this->classe_id);
            });
        })->when($this->frais_id, function ($query) {
            return $query->where('frais_id', $this->frais_id);
        })->when($this->month, function ($query) {
            return $query->where('custom_property', 'like', '%' . $this->month . '%');
        })->orderBy('inscription_id')->get();


    }


    public function getInsolvablesProperty(): \Illuminate\Database\Eloquent\Collection
    {
        return Inscription::whereNotIn('id', $this->perceptions->pluck('inscription_id'))->when($this->section_id, function ($query) {
            return $query->whereHas('classe', function ($query) {
                $query->where('section_id', $this->section_id);
            });
        })->when($this->classe_id, function ($query) {
            return $query->where('classe_id', $this->classe_id);
        })->get();
    }


    public function printIt(): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        //$this->dispatchBrowserEvent('printIt', ['elementId' => "factPrint", 'type' => 'html', 'maxWidth' => '100%']);

        return $this->printToPdf('livewire.finance.rapports.modals.insolvables-printable', $this->all(), $this->title . '.pdf');

    }
}
