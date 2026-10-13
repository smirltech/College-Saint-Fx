<?php

namespace App\Traits;


use App\Helpers\Helpers;

trait HasMontant
{

    public function montant(): string
    {
        return Helpers::currencyFormat($this->montant, symbol: $this?->devise?->symbol());
    }

}
