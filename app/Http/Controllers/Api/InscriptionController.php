<?php

namespace App\Http\Controllers\Api;

use App\Models\Inscription;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class InscriptionController extends Controller
{
    use DisableAuthorization;

    protected $model = Inscription::class;

    public function includes(): array
    {
        return ['eleve', 'annee', 'classe'];
    }

    public function alwaysIncludes(): array
    {
        return ['eleve', 'classe'];
    }

    public function exposedScopes(): array
    {
        return ['annee', 'eleve', 'classe'];
    }


}
