<?php

namespace App\Traits;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\QueryException;
use Jantinnerezo\LivewireAlert\LivewireAlert;

trait CanDeleteModel
{
    use LivewireAlert;

    public function deleteModel(Model $model, string $successMessage = 'Supprimé avec succès', string $failureMessage = 'Erreur lors de la suppression'): void
    {
        try {
            $model->delete();
            $this->alert('success', $successMessage);
        } catch (QueryException) {
            $this->alert('error', $failureMessage);
        }
    }


    // refresh data after deleting media


}
