<?php

namespace App\Enums;

enum InscriptionCategorie: int
{
    case normal = 1;
    case enfant_enseignant = 2;
    case petif_enfant_enseignant = 6;
    case enfant_personnel = 5;
    case petif_enfant_personnel = 7;
    case enfant_5 = 3;
    case enfant_6 = 4;
    case enfant_inspecteur = 8;
    case abandon = 9;


    // label() is a method that a string value
    public function label(): string
    {
        return match ($this) {
            self::normal => 'Normal',
            self::enfant_personnel => 'Enfant du personnel',
            self::petif_enfant_personnel => 'Petit enfant personnel',
            self::enfant_enseignant => 'Enfant enseignant',
            self::petif_enfant_enseignant => 'Petit enfant enseignant',
            self::enfant_5 => '5e enfant',
            self::enfant_6 => '6e enfant',
            self::enfant_inspecteur => 'Enfant inspecteur',
            self::abandon => 'Abandon',
        };
    }
}
