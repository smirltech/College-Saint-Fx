<?php

namespace App\Traits;

use App\Models\Option;
use App\Models\Section;

trait ClasseCode
{
    // set code
    public function setCode()
    {
        if ($this->niveau and $this->filiere_id) {
            $filiere = Option::find($this->filiere_id);
            $this->code = "{$this->niveau} {$filiere->code}";
        }else if ($this->niveau and $this->option_id) {
            $option = Option::find($this->option_id);
            $this->code = "{$this->niveau} {$option->code}";
        }else if ($this->niveau and $this->section_id) {
            $section = Section::find($this->section_id);
            $this->code = "{$this->niveau} {$section->code}";
        }
    }

}
