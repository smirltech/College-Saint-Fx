<?php

namespace App\Http\Livewire\Bibliotheque\Ouvrage;

use App\Models\Ouvrage;
use Illuminate\Contracts\Foundation\Application;
use Illuminate\Contracts\View\Factory;
use Illuminate\Contracts\View\View;
use Livewire\Component;

class OuvrageReadComponent extends Component
{


    public Ouvrage $ouvrage;

    public function render(): Factory|View|Application
    {
        return view('livewire.bibliotheque.ouvrages.read')->layout('layouts.read')->with('title', 'Lire un ouvrage');
    }

}
