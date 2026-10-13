<?php

use App\Http\Livewire\Finance;
use App\Http\Livewire\Finance\Rapports\RapportsMinervalsComponent;
use Illuminate\Support\Facades\Route;

Route::get('finance', Finance\Dashboard\DashboardComponent::class)->name('finance')->middleware('auth');

Route::prefix('finance')->middleware(['auth:web'])->as('finance.')->group(function () {

    // Rapport
    Route::get('rapports', Finance\Rapports\RapportIndexComponent::class)->name('rapports');

    //Revenu
    Route::get('revenus', Finance\Revenu\RevenuIndexComponent::class)->name('revenus');

    //Depense
    Route::get('depenses/{depense}/edit', Finance\Depenses\DepenseCreateComponent::class)->name('depenses.edit');
    Route::get('depenses/create', Finance\Depenses\DepenseCreateComponent::class)->name('depenses.create');
    Route::get('depenses/{depense}', Finance\Depenses\DepenseShowComponent::class)->name('depenses.show');
    Route::get('depenses', Finance\Depenses\DepenseIndexComponent::class)->name('depenses.index');

    Route::get('depense-types', Finance\DepenseType\DepenseTypeIndexComponent::class)->name('depense-types');
    Route::get('depense-types/{depenseType}', Finance\DepenseType\DepenseTypeShowComponent::class)->name('depense-types.show');

    //Frais
    Route::get('frais/create', Finance\Frais\FraisCreateComponent::class)->name('frais.create');
    Route::get('frais', Finance\Frais\FraisIndexComponent::class)->name('frais');

    //Perception
    Route::get('perceptions/import', Finance\Perception\ImportPerceptionComponent::class)->name('perceptions.import');
    Route::get('perceptions/create', Finance\Perception\PerceptionCreateComponent::class)->name('perceptions.create');
    Route::get('perceptions/classe_create', Finance\Perception\PerceptionClasseCreateComponent::class)->name('perceptions.classe-create');
    Route::get('perceptions/{perception}/edit', Finance\Perception\PerceptionEditComponent::class)->name('perceptions.edit');
    Route::get('perceptions/{perception}/print', Finance\Perception\PerceptionPrintComponent::class)->name('perceptions.print');
    Route::get('perceptions', Finance\Perception\PerceptionIndexComponent::class)->name('perceptions');
    Route::get('caisse', Finance\Perception\CaisseComponent::class)->name('caisse');


    Route::get('rapports', Finance\Rapports\RapportIndexComponent::class)->name('rapports.minervals');
    Route::get('insolvables', Finance\Rapports\RapportInsolvablesComponent::class)->name('rapports.insolvables');
    //Route::get('rapports/minervals', RapportsMinervalsComponent::class)->name('rapports.minervals');
    //Perception
    //Route::get('eleves', Finance\Eleve\EleveIndexComponent::class)->name('eleves');
    // Route::get('eleves/{id}', Finance\Eleve\EleveShowComponent::class)->name('eleves.show');

    Route::get('journalier', Finance\Rapports\RapportJournalierComponent::class)
        ->name('rapports.journalier');
});

