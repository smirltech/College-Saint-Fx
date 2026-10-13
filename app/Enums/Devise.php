<?php

namespace App\Enums;

enum Devise: string
{
    case USD = 'USD';
    case CDF = 'CDF';

    public function symbol(): string
    {
        return match ($this) {
            self::USD => '$',
            self::CDF => 'FC',
        };
    }

    // label is used for displaying the enum value in the UI
    /*public function label(): string
    {
        return match ($this) {
            self::USD => 'Dollar Américain',
            self::CDF => 'Franc Congolais',
        };
    }*/


}
