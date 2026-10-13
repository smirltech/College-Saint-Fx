<?php

use App\Http\Livewire\Scolarite;
use App\Http\Livewire\Scolarite\Eleve\RechercheEleveComponent;
use App\Http\Livewire\Scolarite\Inscription\InscriptionCreateComponent;
use Illuminate\Support\Facades\Route;

Route::get('scolarite', Scolarite\DashboardComponent::class)->name('scolarite')->middleware('auth');

Route::prefix('scolarite')->middleware(['auth:web'])->as('scolarite.')->group(function () {

    // toogle dark mode

//Section
    Route::get('sections/{section}', Scolarite\Section\SectionShowComponent::class)->name('sections.show');
    Route::get('sections', Scolarite\Section\SectionIndexComponent::class)->name('sections');

    //Option
    Route::get('options/{option}', Scolarite\Option\OptionShowComponent::class)->name('options.show');
    Route::get('options', Scolarite\Option\OptionIndexComponent::class)->name('options');

//Option
    Route::get('filieres/{filiere}', Scolarite\Filiere\FiliereShowComponent::class)->name('filieres.show');
    Route::get('filieres', Scolarite\Filiere\FiliereIndexComponent::class)->name('filieres');

// Classe
    Route::get('classes/create', Scolarite\Classe\ClasseEditComponent::class)->name('classes.create');
    Route::get('classes/{classe}/edit', Scolarite\Classe\ClasseEditComponent::class)->name('classes.edit');
    Route::get('classes/{classe}', Scolarite\Classe\ClasseShowComponent::class)->name('classes.show');
    Route::get('classes', Scolarite\Classe\ClasseIndexComponent::class)->name('classes.index');

    // cours
    Route::get('cours', Scolarite\Cours\CoursIndexComponent::class)->name('cours.index');
    Route::get('cours/create', Scolarite\Cours\CoursCreateComponent::class)->name('cours.create');
    Route::get('cours/{cours}/edit', Scolarite\Cours\CoursEditComponent::class)->name('cours.edit');
    Route::get('cours/{cours}', Scolarite\Classe\ClasseShowComponent::class)->name('cours.show');

    // devoirs
    Route::get('devoirs', Scolarite\Devoir\DevoirIndexComponent::class)->name('devoirs.index');
    Route::get('devoirs/create', Scolarite\Devoir\DevoirCreateComponent::class)->name('devoirs.create');
    Route::get('devoirs/{devoir}/edit', Scolarite\Devoir\DevoirEditComponent::class)->name('devoirs.edit');
    Route::get('devoirs/{devoir}', Scolarite\Devoir\DevoirShowComponent::class)->name('devoirs.show');

    // devoirs
    Route::get('resultats/classe/{classe}', Scolarite\Resultat\ResultatIndexComponent::class)->name('resultats.classe');

    // Enseignant
    Route::get('enseignants', Scolarite\Enseignant\EnseignantIndexComponent::class)->name('enseignants.index');
    Route::get('enseignants/create', Scolarite\Enseignant\EnseignantCreateComponent::class)->name('enseignants.create');
    Route::get('enseignants/{enseignant}/edit', Scolarite\Enseignant\EnseignantEditComponent::class)->name('enseignants.edit');
    Route::get('enseignants/{enseignant}', Scolarite\Enseignant\EnseignantShowComponent::class)->name('enseignants.show');

// Année
    Route::get('annees', Scolarite\Annee\AnneeComponent::class)->name('annees');

// Eleves
    Route::get('presences', Scolarite\Presences\PresencesIndexComponent::class)->name('presences.index');

    Route::get('eleves/recherche', RechercheEleveComponent::class)->name('eleves.recherche');
    Route::get('eleves/{eleve}', Scolarite\Eleve\EleveShowComponent::class)->name('eleves.show');
    Route::get('eleves/{eleve}/presence', Scolarite\Eleve\PresenceComponent::class)->name('eleves.presence');
    Route::get('eleves', Scolarite\Eleve\EleveIndexComponent::class)->name('eleves.index');

    Route::get('inscriptions/import', Scolarite\Eleve\EleveImportComponent::class)->name('inscriptions.import');
    Route::get('inscriptions/create', Scolarite\Inscription\InscriptionCreateComponent::class)->name('inscriptions.create');
    Route::get('inscriptions/{inscription}/edit', InscriptionCreateComponent::class)->name('inscriptions.edit');
    Route::get('inscriptions/status/{status}', Scolarite\Inscription\ByStatus\InscriptionStatusComponent::class)->name('inscriptions.status');
    Route::redirect('inscriptions', 'eleves')->name('inscriptions');
    Route::get('responsables/{responsable}', Scolarite\Responsable\ResponsableShowComponent::class)->name('responsables.show');
    Route::get('responsables', Scolarite\Responsable\ResponsableIndexComponent::class)->name('responsables.index');




});

