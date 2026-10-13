<?php

namespace App\Traits;

trait FiliereCode
{
    // set code
    public function setCode()
    {
        if(isset($this->classe_grade)) {
            if ($this->classe_grade) {

                $this->classe_code = "{$this->classe_grade} {$this->filiere->code}";
            }
        }
    }

}
