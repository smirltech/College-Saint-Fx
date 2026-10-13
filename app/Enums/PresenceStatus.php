<?php

namespace App\Enums;

enum PresenceStatus: string
{
    case PRESENT = 'present';
    case ABSENT = 'absent';
    case MALADE = 'malade';
    case AUTRE = 'autre';

    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::PRESENT => 'Présent',
            self::ABSENT => 'Absent',
            self::MALADE => 'Malade',
            self::AUTRE => 'Autre',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::PRESENT => 'success',
            self::ABSENT => 'danger',
            self::MALADE => 'warning',
            self::AUTRE => 'info',
        };
    }

    public function colorNonBootstrap(): string
    {
        return match ($this) {
            self::PRESENT => 'green',
            self::ABSENT => 'red',
            self::MALADE => 'orange',
            self::AUTRE => 'teal',
        };
    }
}
