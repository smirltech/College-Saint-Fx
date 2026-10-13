<?php

namespace App\Http\Livewire\Bibliotheque\Rayons;

use App\Http\Livewire\BaseComponent;
use App\Models\Rayon;
use App\Traits\TopMenuPreview;
use App\View\Components\AdminLayout;
use Exception;
use Illuminate\Auth\Access\AuthorizationException;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Jantinnerezo\LivewireAlert\LivewireAlert;

class RayonIndexComponent extends BaseComponent
{
    use TopMenuPreview;
    use LivewireAlert;

    // protected $paginationTheme = 'bootstrap';

    public Rayon $category;
    public $categories = [];
    protected $rules = [
        'category.nom' => 'required',
        'category.rayon_id' => 'nullable',
        'category.description' => 'nullable',
    ];

    /**
     * @throws AuthorizationException
     */
    public function mount(): void
    {
        $this->authorize("viewAny", Rayon::class);
        $this->initCategory();
        $this->loadData();
    }

    public function initCategory(): void
    {
        $this->category = new Rayon();
    }

    public function loadData(): void
    {
        $this->categories = Rayon::orderBy('nom')->get();
    }

    public function render(): View|Factory|Application
    {
        $this->loadData();
        return view('livewire.bibliotheque.rayons.index')
            ->layout(AdminLayout::class, ['title' => "Liste de Categories"]);
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


    public function getSelectedCategory(Rayon $category)
    {
        $this->category = $category;
    }

    public function updateCategory()
    {
        $this->validate();

        $done = $this->category->save();
        if ($done) {
            $this->onModalClosed('update-category-modal');
            $this->alert('success', "Catégorie modifiée avec succès !");
        } else {
            $this->alert('warning', "Échec de modification de catégorie !");
        }

    }

    public function deleteCategory()
    {
        try {
            $this->category->delete();
            $this->loadData();
            $this->alert('success', "Catégorie supprimée avec succès !");

        } catch (Exception $e) {
            $this->alert('warning', "Cette catégorie n'a pas été supprimée, il y a des ouvrages attachés !");
        }

        $this->onModalClosed('delete-category-modal');

    }

}
