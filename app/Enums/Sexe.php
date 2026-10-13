<?php

namespace App\Enums;

enum Sexe: string
{
    case F = 'F';
    case M = 'M';

    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::F => 'Feminin',
            self::M => 'Masculin',
        };
    }
}
