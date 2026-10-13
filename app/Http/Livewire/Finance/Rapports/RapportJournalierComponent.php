<?php

namespace App\Http\Livewire\Finance\Rapports;

use App\Models\Annee;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Livewire\Component;
use Barryvdh\DomPDF\Facade\Pdf;

class RapportJournalierComponent extends Component
{
    public $date_from;
    public $date_to;
    public $annee_id = 5;

    public function mount()
    {
        $this->date_from = Carbon::today()->format('Y-m-d');
        $this->date_to   = Carbon::today()->format('Y-m-d');
    }

    public function updatedDateFrom()
    {
        if ($this->date_from > $this->date_to) {
            $this->date_to = $this->date_from;
        }
    }

    public function updatedDateTo()
    {
        if ($this->date_to < $this->date_from) {
            $this->date_from = $this->date_to;
        }
    }

    private function getData(): array
    {
        $base = DB::table('perceptions as p')
            ->join('inscriptions as i', 'i.id', '=', 'p.inscription_id')
            ->join('classes as c', 'c.id', '=', 'i.classe_id')
            ->leftJoin('sections as s', 's.id', '=', 'c.section_id')
            ->join('frais as f', 'f.id', '=', 'p.frais_id')
            ->whereNull('p.deleted_at')
            ->where('p.annee_id', $this->annee_id)

            ->whereDate('p.created_at', '>=', $this->date_from)
            ->whereDate('p.created_at', '<=', $this->date_to);


        $totauxSections = (clone $base)
            ->selectRaw("COALESCE(s.nom, 'Sans section') AS section,
                         COUNT(DISTINCT i.eleve_id) AS nb_eleves")
            ->groupBy('s.id', 's.nom')
            ->orderBy('s.nom')
            ->get()
            ->keyBy('section');


        $details = (clone $base)
            ->selectRaw("COALESCE(s.nom, 'Sans section') AS section,
                         f.nom AS frais,
                         p.devise,
                         COUNT(DISTINCT i.eleve_id) AS nb_eleves,
                         SUM(p.montant) AS total")
            ->groupBy('s.id', 's.nom', 'f.id', 'f.nom', 'p.devise')
            ->orderBy('s.nom')
            ->orderBy('f.nom')
            ->get()
            ->groupBy('section');

        $sections = $totauxSections->map(function ($row, $nom) use ($details) {
            $lignes = $details->get($nom, collect());
            return (object) [
                'nom'       => $nom,
                'nb_eleves' => $row->nb_eleves,
                'lignes'    => $lignes,
                'totaux'    => $lignes->groupBy('devise')->map(fn($g) => $g->sum('total')),
            ];
        })->values();

        $totalGeneral = $sections->flatMap->lignes->groupBy('devise')->map(fn($g) => $g->sum('total'));
        $totalEleves  = (clone $base)->distinct()->count('i.eleve_id');

        return [
            'sections'     => $sections,
            'totalGeneral' => $totalGeneral,
            'totalEleves'  => $totalEleves,
        ];
    }

    public function setPeriode(string $type): void
    {
        $today = Carbon::today();

        match ($type) {
            'today'     => [$this->date_from, $this->date_to] = [$today->format('Y-m-d'), $today->format('Y-m-d')],
            'yesterday' => [$this->date_from, $this->date_to] = [$today->copy()->subDay()->format('Y-m-d'), $today->copy()->subDay()->format('Y-m-d')],
            'week'      => [$this->date_from, $this->date_to] = [$today->copy()->startOfWeek()->format('Y-m-d'), $today->format('Y-m-d')],
            'month'     => [$this->date_from, $this->date_to] = [$today->copy()->startOfMonth()->format('Y-m-d'), $today->format('Y-m-d')],
        };
    }

    public function resetFiltre(): void
    {
        $this->setPeriode('today');
    }


private function getPrintData(): array
{
    $base = DB::table('perceptions as p')
        ->join('inscriptions as i', 'i.id', '=', 'p.inscription_id')
        ->join('classes as c', 'c.id', '=', 'i.classe_id')
        ->leftJoin('sections as s', 's.id', '=', 'c.section_id')
        ->join('frais as f', 'f.id', '=', 'p.frais_id')
        ->leftJoin('sessions as se', 'se.id', '=', 'i.session_id')
        ->whereNull('p.deleted_at')
        ->where('p.annee_id', $this->annee_id)
        ->whereDate('p.created_at', '>=', $this->date_from)
        ->whereDate('p.created_at', '<=', $this->date_to);


    $lignes = (clone $base)
        ->selectRaw("
            COALESCE(s.nom, 'Sans section') AS section,
            COALESCE(se.nom, 'Sans session') AS session,
            f.nom AS frais,
            p.devise,
            COUNT(DISTINCT i.eleve_id) AS nb_eleves,
            SUM(p.montant) AS total
        ")
        ->groupBy(
            's.id',
            's.nom',
            'se.id',
            'se.nom',
            'f.id',
            'f.nom',
            'p.devise'
        )
        ->orderBy('s.nom')
        ->orderBy('se.nom')
        ->orderBy('f.nom')
        ->get();


    $effectifs = (clone $base)
        ->selectRaw("
            COALESCE(s.nom, 'Sans section') AS section,
            COALESCE(se.nom, 'Sans session') AS session,
            COUNT(DISTINCT i.eleve_id) AS nb_eleves
        ")
        ->groupBy('s.id', 's.nom', 'se.id', 'se.nom')
        ->get()
        ->keyBy(fn ($row) => $row->section . '|' . $row->session);

    // Organisation des données : section > session > frais
    $sections = $lignes
        ->groupBy('section')
        ->map(function ($lignesSection, $nomSection) use ($effectifs) {
            $sessions = $lignesSection
                ->groupBy('session')
                ->map(function ($lignesSession, $nomSession) use (
                    $effectifs,
                    $nomSection
                ) {
                    $cle = $nomSection . '|' . $nomSession;
                    $effectif = $effectifs->get($cle);

                    return (object) [
                        'nom' => $nomSession,
                        'nb_eleves' => $effectif?->nb_eleves ?? 0,
                        'lignes' => $lignesSession->values(),
                        'totaux' => $lignesSession
                            ->groupBy('devise')
                            ->map(fn ($g) => $g->sum('total')),
                    ];
                })
                ->values();

            return (object) [
                'nom' => $nomSection,
                'sessions' => $sessions,
                'totaux' => $lignesSection
                    ->groupBy('devise')
                    ->map(fn ($g) => $g->sum('total')),
            ];
        })
        ->values();

    return [
        'sections' => $sections,
        'totalGeneral' => $lignes
            ->groupBy('devise')
            ->map(fn ($g) => $g->sum('total')),
        'totalEleves' => (clone $base)
            ->distinct()
            ->count('i.eleve_id'),
        'date_from' => $this->date_from,
        'date_to' => $this->date_to,
    ];
}

public function printIt()
{
    $data = $this->getPrintData();

    $pdf = Pdf::loadView(
        'livewire.finance.rapports.modals.printablejournalier',
        $data
    )->setPaper('a4', 'landscape');

    return response()->streamDownload(
        fn () => print($pdf->output()),
        "rapport-journalier-{$this->date_from}-{$this->date_to}.pdf"
    );
}


    public function render()
    {
        return view('livewire.finance.rapports.rapport-journalier-component', $this->getData());
    }
}