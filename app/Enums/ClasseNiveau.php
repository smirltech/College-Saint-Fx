<?php

namespace App\Enums;

enum ClasseNiveau: int
{
    case n1 = 1;
    case n2 = 2;
    case n3 = 3;
    case n4 = 4;
    case n5 = 5;
    case n6 = 6;
    case n7 = 7;
    case n8 = 8;

    public function label(): string
    {
        return match ($this) {
            self::n1 => '1ère',
            self::n2 => '2ème',
            self::n3 => '3ème',
            self::n4 => '4ème',
            self::n5 => '5ème',
            self::n6 => '6ème',
            self::n7 => '7ème',
            self::n8 => '8ème',
        };
    }
}
