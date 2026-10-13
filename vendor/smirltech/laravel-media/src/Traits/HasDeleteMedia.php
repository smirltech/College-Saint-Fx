<?php

namespace SmirlTech\LaravelMedia\Traits;

use Livewire\Redirector;
use SmirlTech\LaravelMedia\Models\Media;
trait HasDeleteMedia
{
    public function deleteMedia(Media $media): void
    {
        if ($media->delete()) {
            $this->emit('mediaDeleted');
            $this->emit('refresh');

           /*if(method_exists($this, 'success')){
               $this->success(message: 'Le document a été supprimé avec succès');
           }*/
        }
    }

}
