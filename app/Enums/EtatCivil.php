<?php

namespace App\Enums;

enum EtatCivil: string
{
    case single = 'single';
    case married = 'married';
    case divorced = 'divorced';
    case widowed = 'widowed';


    // label() is a method that returns the label of the enum value
    public function label(): string
    {
        return match ($this) {
            self::single => 'Célibataire',
            self::married => 'Marié(e)',
            self::divorced => 'Divorcé(e)',
            self::widowed => 'Veuf(ve)',
        };
    }

}
