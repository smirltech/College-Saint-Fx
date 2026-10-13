<?php

namespace App\Enums;


enum ResultatType: int
{
    case p1 = 1;
    case p2 = 2;
    case ex1 = 3;
    case t1 = 4;

    case p3 = 5;
    case p4 = 6;
    case ex2 = 7;
    case t2 = 8;

    case p5 = 9;
    case p6 = 10;
    case ex3 = 11;
    case t3 = 12;

    case tg = 13;



    // label() match expression
    public function label(): string
    {
        return match ($this) {
            self::p1 => '1e',
            self::p2 => '2e',
            self::ex1 => 'Ex 1',
            self::t1 => 'Tr 1',

            self::p3 => '3e',
            self::p4 => '4e',
            self::ex2 => 'Ex 2',
            self::t2 => 'Tr 2',

            self::p5 => '5e',
            self::p6 => '6e',
            self::ex3 => 'Ex 3',
            self::t3 => 'Tr 3',

            self::tg => 'TG',
        };
    }

    public function longLabel(): string
    {
        return match ($this) {
            self::p1 => '1e Période',
            self::p2 => '2e Période',
            self::ex1 => 'Examen 1e Trimestre',
            self::t1 => '1e Trimestre',

            self::p3 => '3e Période',
            self::p4 => '4e Période',
            self::ex2 => 'Examen 2e Trimestre',
            self::t2 => '2e Trimestre',

            self::p5 => '5e Période',
            self::p6 => '6e Période',
            self::ex3 => 'Examen 3e Trimestre',
            self::t3 => '3e Trimestre',

            self::tg => 'Total Général',
        };
    }
}
