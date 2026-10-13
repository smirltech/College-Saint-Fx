<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class FiliereController extends Controller
{
    use DisableAuthorization;

    protected $model = Option::class;

    public function includes(): array
    {
        return ['classes', 'classes.inscriptions'];
    }
}
