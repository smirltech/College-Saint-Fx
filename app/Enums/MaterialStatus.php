<?php

namespace App\Enums;

enum MaterialStatus: string
{
    case ok = 'ok';
    case damaged = 'damaged';
    case repairing = 'repairing';
    case lost = 'lost';

    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::ok => 'Ok',
            self::damaged => 'Endommagé',
            self::repairing => 'À la réparation',
            self::lost => 'Perdu',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::ok => 'primary',
            self::damaged => 'danger',
            self::repairing => 'warning',
            self::lost => 'secondary',
        };
    }
}
