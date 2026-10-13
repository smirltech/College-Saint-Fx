<?php

namespace App\Http\Livewire;

use App\Traits\HasLivewireAlert;
use App\Traits\WithFileUploads;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Livewire\Component;
use URL;

class BaseComponent extends Component
{
    use AuthorizesRequests, HasLivewireAlert, WithFileUploads;

    public function onModalClosed($id = null): void
    {
        if ($id) {
            $this->dispatchBrowserEvent('closeModal', ['modal' => $id]);
        }
        $this->redirect(URL::previous());
    }
}
