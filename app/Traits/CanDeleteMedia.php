<?php

namespace App\Traits;

use App\Models\Media;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait CanDeleteMedia
{
    use LivewireAlert, CanDeleteModel;


    public function deleteMedia(Media $media): void
    {
        $fileName = $media->filename;
        if ($media->delete()) {
            $this->refreshData();
            $this->alert('success', "Le fichier {$fileName} a été supprimé avec succès");
        } else {
            $this->alert('error', "Erreur lors de la suppression du fichier {$fileName}");
        }
    }

    // refresh data after deleting media
    abstract private function refreshData(): void;


}
