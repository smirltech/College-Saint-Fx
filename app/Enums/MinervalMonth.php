<?php

namespace App\Enums;

enum MinervalMonth: int
{
    case SEPTEMBRE = 9;
    case OCTOBRE = 10;
    case NOVEMBRE = 11;
    case DECEMBRE = 12;
    case JANVIER = 1;

    case FEVRIER = 2;
    case MARS = 3;
    case AVRIL = 4;
    case MAI = 5;
    case JUIN = 6;
    case JUILLET = 7;



    public function label(): string
    {
        return match ($this) {
            self::SEPTEMBRE => 'Septembre',
            self::OCTOBRE => 'Octobre',
            self::NOVEMBRE => 'Novembre',
            self::DECEMBRE => 'Décembre',
            self::JANVIER => 'Janvier',
            self::FEVRIER => 'Février',
            self::MARS => 'Mars',
            self::AVRIL => 'Avril',
            self::MAI => 'Mai',
            self::JUIN => 'Juin',
            self::JUILLET => 'Juillet',
        };
    }

    public function code (): string
    {
        return match ($this) {
            self::SEPTEMBRE => 'SEP',
            self::OCTOBRE => 'OCT',
            self::NOVEMBRE => 'NOV',
            self::DECEMBRE => 'DEC',
            self::JANVIER => 'JAN',
            self::FEVRIER => 'FEV',
            self::MARS => 'MAR',
            self::AVRIL => 'AVR',
            self::MAI => 'MAI',
            self::JUIN => 'JUN',
            self::JUILLET => 'JUL',
        };
    }



}
