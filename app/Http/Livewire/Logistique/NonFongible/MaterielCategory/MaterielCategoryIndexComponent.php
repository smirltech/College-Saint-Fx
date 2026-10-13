<?php

namespace App\Http\Livewire\Logistique\NonFongible\MaterielCategory;

use App\Http\Livewire\BaseComponent;
use App\Models\MaterielCategory;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Illuminate\Validation\Rule;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class MaterielCategoryIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    public $categories = [];
    public MaterielCategory $category;

    protected $rules = [
        'category.nom' => 'required|unique:materiel_categories,nom',
        'category.materiel_category_id' => 'nullable',
        'category.description' => 'nullable',
    ];

    public function mount(): void
    {
        $this->authorize("viewAny", MaterielCategory::class);
        $this->initCategory();
    }

    public function initCategory(): void
    {
        $this->category = new MaterielCategory();
    }

    public function render(): View|\Illuminate\Foundation\Application|Factory|Application
    {
        $this->loadData();
        return view('livewire.logistiques.non_fongibles.materiel_categories.index')
            ->layout(AdminLayout::class, ['title' => 'Liste de Categories des Matériels']);
    }

    public function loadData(): void
    {
        $this->categories = MaterielCategory::orderBy('nom', 'ASC')->get()/* ->sortBy('groupe_nom')*/
        ;
        //  dd($this->categories);
    }

    public function addCategory(): void
    {
        $this->validate();

        try {
            $done = $this->category->save();
            if ($done) {
                $this->onModalClosed('add-category-modal');
                $this->loadData();
                $this->initCategory();
                $this->alert('success', "Catégorie ajoutée avec succès !");
            } else {
                $this->alert('warning', "Échec d'ajout de catégorie !");
            }
        } catch (Exception $exception) {
            //  dd($exception);
            $this->alert('error', "Échec de d'ajout de catégorie, ce nom existe déjà !");
        }

    }


    public function getSelectedCategory(MaterielCategory $category): void
    {
        $this->category = $category;
        // dd($this->category->categories);
    }

    public function updateCategory(): void
    {
        $this->validate([
            'category.nom' => [
                "required",
                Rule::unique((new MaterielCategory())->getTable(), "nom")->ignore($this->category->id)
            ],
            'category.description' => 'nullable',
            'category.materiel_category_id' => 'nullable',
        ]);

        $done = $this->category->save();
        if ($done) {
            $this->onModalClosed('update-category-modal');
            $this->alert('success', "Catégorie modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de catégorie !");
        }

    }

    public function deleteCategory(): void
    {
        if ($this->category->categories->count() == 0 && $this->category->materiels->count() == 0) {
            if ($this->category->delete()) {
                $this->loadData();
                $this->alert('success', "Catégorie supprimée avec succès !");
            }
        } else {
            $this->alert('warning', "Catégorie n'a pas été supprimée, il y a des éléments attachés !");
        }
        $this->onModalClosed('delete-category-modal');

    }
}
