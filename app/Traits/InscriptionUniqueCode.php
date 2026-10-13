<?php

namespace App\Traits;

use App\Models\Inscription;

trait InscriptionUniqueCode
{
    // set code
    public function getGeneratedInscriptionUniqueCode()
    {

            do {
                $code = random_int(10000000, 99999999);
            } while (Inscription::where("code", "=", $code)->first());

            return $code;

    }

}
