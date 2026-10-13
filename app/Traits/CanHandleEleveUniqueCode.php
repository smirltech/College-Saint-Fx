<?php

namespace App\Traits;

use App\Models\Eleve;

trait CanHandleEleveUniqueCode
{
    // set code
    public function getGeneratedUniqueCode()
    {

        do {
            $code = random_int(10000000, 99999999);
        } while (Eleve::where("code", "=", $code)->first());

        return $code;

    }

}
