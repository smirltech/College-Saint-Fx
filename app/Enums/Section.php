<?php

namespace App\Enums;

enum Section: string
{
    case MATERNELLE = 'MAT';
    case PRIMAIRE = 'P';
    case SECONDAIRE = 'S';

    public function label(): string
    {
        return match ($this) {
            self::MATERNELLE => 'Maternelle',
            self::PRIMAIRE => 'Primaire',
            self::SECONDAIRE => 'Secondaire',
        };
    }

    public function level(): int
    {
        return match ($this) {
            self::MATERNELLE => 1,
            self::PRIMAIRE => 2,
            self::SECONDAIRE => 4,
        };
    }
}
