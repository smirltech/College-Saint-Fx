<?php

namespace App\Enums;

use Exception;

enum FraisType: string
{
    case INSCRIPTION = 'INSCRIPTION';
    case MINERVAL = 'MINERVAL';
    case KIT = 'KIT';
    case ETAT = 'ETAT';
    case CONNEXE = 'CONNEXE';
    case AUTRE = 'AUTRE';

    public function folder(): string
    {
        return match ($this) {
            self::INSCRIPTION => 'inscriptions',
            self::KIT => 'kits',
            self::ETAT => 'etat',
            self::CONNEXE => 'connexe',
            self::MINERVAL => 'minerval',
            self::AUTRE => 'autre',
        };
    }

    public function label(): string
    {
        return match ($this) {
            self::INSCRIPTION => 'Frais d\'inscription',
            self::KIT => 'Frais de kit',
            self::ETAT => 'Frais de l\'état',
            self::CONNEXE => 'Frais connexe',
            self::MINERVAL => 'Frais de minerval',
            self::AUTRE => 'Autre frais',
        };
    }

    public function subtypes(): ?array
    {
        return match ($this) {
            self::MINERVAL, self::KIT, self::INSCRIPTION, self::CONNEXE, self::AUTRE => null,
            self::ETAT => EtatType::cases(),
        };
    }

    public function properties(): ?array
    {
        return match ($this) {
            self::MINERVAL => MinervalMonth::cases(),
            self::ETAT, self::KIT, self::INSCRIPTION, self::CONNEXE, 
            self::AUTRE => MinervalMonth::cases(),
        };
    }


}
