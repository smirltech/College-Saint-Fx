<?php

namespace App\Http\Controllers;

use App\Http\Livewire\Finance\Rapports\RapportJournalierComponent;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Http\Request;

class RapportJournalierPdfController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'date_from' => ['required', 'date'],
            'date_to'   => ['required', 'date', 'after_or_equal:date_from'],
            'annee_id'  => ['required', 'integer'],
        ]);

        $data = RapportJournalierComponent::buildPrintData(
            $request->annee_id,
            $request->date_from,
            $request->date_to
        );

        return Pdf::loadView(
            'livewire.finance.rapports.modals.printablejournalier',
            $data
        )
            ->setPaper('a4', 'landscape')
            ->download("rapport-journalier-{$request->date_from}-{$request->date_to}.pdf");
    }
}