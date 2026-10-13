<?php

namespace App\Enums;

enum DevoirReponseStatus: string
{

    case pending = 'pending';
    case processed = 'processed';
    case rejected = 'rejected';
    case late = 'late';

    // label() method
    public function label(): string
    {
        return match ($this) {
            self::pending => 'En attente',
            self::processed => 'Traité',
            self::rejected => 'Rejetté',
            self::late => 'En retard',
        };
    }

}
