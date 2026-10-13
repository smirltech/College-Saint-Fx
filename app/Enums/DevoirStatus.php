<?php

namespace App\Enums;


enum DevoirStatus: string
{
    case draft = 'draft';
    case open = 'open';
    case closed = 'closed';

    // label() match expression
    public function label(): string
    {
        return match ($this) {
            self::draft => 'Brouillon',
            self::open => 'Ouvert',
            self::closed => 'Fermé',
        };
    }

    public function variant(): string
    {
        return match ($this) {
            self::draft => 'secondary',
            self::open => 'success',
            self::closed => 'danger',
        };
    }
}
