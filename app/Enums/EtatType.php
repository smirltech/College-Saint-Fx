<?php

namespace App\Enums;

enum EtatType: int
{
    case TRANCHE_1 = 1;
    case TRANCHE_2 = 2;
    case TRANCHE_3 = 3;


    public function label(): string
    {
        return match ($this) {
            self::TRANCHE_1 => 'Tranche 1',
            self::TRANCHE_2 => 'Tranche 2',
            self::TRANCHE_3 => 'Tranche 3',
        };
    }



}
