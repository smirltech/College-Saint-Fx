<?php

namespace App\Http\Controllers\Api;

use App\Models\Option;
use Orion\Concerns\DisableAuthorization;
use Orion\Http\Controllers\Controller;

class OptionController extends Controller
{
    use DisableAuthorization;

    protected $model = Option::class;

    public function includes(): array
    {
        return ['filieres', 'classes', 'classes.inscriptions'];
    }

}
