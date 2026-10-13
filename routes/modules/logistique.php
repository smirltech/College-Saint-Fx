<?php

use App\Http\Livewire\Logistique;
use App\Http\Livewire\Logistique\Fongible\Consommable\ConsommableIndexComponent;
use App\Http\Livewire\Logistique\Fongible\Consommable\ConsommableShowComponent;
use App\Http\Livewire\Logistique\Fongible\Unit\UnitIndexComponent;
use App\Http\Livewire\Logistique\NonFongible\Materiel\MaterielIndexComponent;
use App\Http\Livewire\Logistique\NonFongible\Materiel\MaterielShowComponent;
use App\Http\Livewire\Logistique\NonFongible\MaterielCategory\MaterielCategoryIndexComponent;
use App\Http\Livewire\Logistique\NonFongible\MaterielCategory\MaterielCategoryShowComponent;
use App\Http\Livewire\Logistique\NonFongible\Mouvement\MouvementIndexComponent;

Route::get('logistique', Logistique\DashboardComponent::class)->name('logistique')->middleware('auth');

Route::prefix('logistique')->middleware(['auth:web'])->as('logistique.')->group(function () {

    // materiel categories
    Route::get('categories', MaterielCategoryIndexComponent::class)->name('categories');
    Route::get('categories/{category}', MaterielCategoryShowComponent::class)->name('categories.show');

    // materiels
    Route::get('materiels', MaterielIndexComponent::class)->name('materiels');
    Route::get('materiels/{materiel}', MaterielShowComponent::class)->name('materiels.show');

    // materiels
    Route::get('mouvements', MouvementIndexComponent::class)->name('mouvements');
    Route::get('units', UnitIndexComponent::class)->name('units');

    // materiels
    Route::get('consommables', ConsommableIndexComponent::class)->name('consommables');
    Route::get('consommables/{consommable}', ConsommableShowComponent::class)->name('consommables.show');


});

