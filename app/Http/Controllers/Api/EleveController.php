<?php

namespace App\Http\Controllers\Api;

use App\Models\Eleve;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class EleveController extends Controller
{
    use DisableAuthorization;

    protected $model = Eleve::class;

    public function includes(): array
    {
        return ['inscriptions', 'responsables', 'inscription'];
    }

}
