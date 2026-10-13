<?php

namespace App\Enums;

use EmreYarligan\EnumConcern\EnumConcern;

enum RevenuType: string
{

    use EnumConcern;

    case CANTINE = 'CANTINE';
    case EMPRUNT = 'EMPRUNT';
    case DON = 'DON';
    case AUTRE = 'AUTRE';


    public function label(): string
    {
        return match ($this) {
            self::CANTINE => 'Cantine scolaire',
            self::AUTRE => 'Autre',
            self::EMPRUNT => 'Emprunt',
            self::DON => 'Don',
        };
    }

}
