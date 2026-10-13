<?php

namespace App\Enums;

enum EleveStatus: string
{
    case pending = 'pending';
    case active = 'active';
    case inactive = 'inactive';
    case blocked = 'blocked';

    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::pending => 'En attente',
            self::active => 'Actif',
            self::inactive => 'Inactif',
            self::blocked => 'Bloqué',
        };
    }
}
