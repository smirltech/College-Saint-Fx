<?php

namespace App\Traits;

trait OptionCode
{
    // set code
    public function genCode()
    {
        if(isset($this->nom)) {
            $this->code = strtoupper(substr($this->nom, 0, 3));
        }else{
            $this->option->code = strtoupper(substr($this->option->nom, 0, 3));
        }

        if(isset($this->filiere_nom)) {
            $this->filiere_code = strtoupper(substr($this->filiere_nom, 0, 3));
        }
    }

}
