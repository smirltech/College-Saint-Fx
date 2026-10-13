<?php

namespace App\Enums;

enum MouvementStatus: string
{
    case in = 'in';
    case out = 'out';

    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::in => 'Entrée',
            self::out => 'Sortie',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::in => 'info',
            self::out => 'warning',
        };
    }
}
