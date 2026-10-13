<?php

namespace App\Traits;

use App\Models\Eleve;
use App\Models\Option;
use App\Models\Section;

trait EleveUniqueCode
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
