<?php

namespace App\Traits;

use App\Models\Option;

trait PomotionCode
{
    // set code
    public function setCode()
    {
        if ($this->niveau and $this->filiere_id) {
            $filiere = Option::find($this->filiere_id);
            $this->code = "{$this->niveau} {$filiere->code}";
        }
    }

}
