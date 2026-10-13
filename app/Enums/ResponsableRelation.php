<?php

namespace App\Enums;

enum ResponsableRelation: string
{
    case oncle = 'oncle';
    case tante = 'tante';
    case pere = 'pere';
    case mere = 'mere';
    case frere = 'frere';
    case soeur = 'soeur';
    case autre = 'autre';

    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::oncle => 'Oncle',
            self::tante => 'Tante',
            self::pere => 'Père',
            self::mere => 'Mère',
            self::frere => 'Frère',
            self::soeur => 'Soeur',
            self::autre => 'Autre',

        };
    }

    // reverse() is a method that from the sex, returns the appropriate relation as a string value
    public function reverse(Sexe $sexe): string
    {
        return match ($this) {
            self::oncle, self::tante => $sexe == Sexe::M ? 'Neveux' : 'Niece',
            self::pere, self::mere => $sexe == Sexe::M ? 'Fils' : 'Fille',
            self::frere, self::soeur => $sexe == Sexe::M ? 'Frère' : 'Soeur',
            self::autre => 'Autre',
        };
    }
}
