<?php

namespace App\Enums;

use Carbon\Carbon;

enum GraviteRetard: int
{
    // nombre de jours
    case vert = 15;
    case jaune = 30;
    case rouge = 45;


    // label() is a method that returns the label of the enum
    public static function color(string $dateTime): string
    {
        $dDate = Carbon::now();
        $dayCount = $dDate->diffInDays(Carbon::parse($dateTime));
        if ($dDate->lessThan(Carbon::parse($dateTime))) {
            $dayCount *= -1;
        }
        if ($dayCount < self::vert->value) return 'light';
        else if ($dayCount < self::jaune->value) return self::vert->label();
        else if ($dayCount < self::rouge->value) return self::jaune->label();
        else return self::rouge->label();

    }

    public function label(): string
    {
        return match ($this) {
            self::vert => 'success',
            self::jaune => 'warning',
            self::rouge => 'danger',
        };
    }

    public static function retard(string $dateTime): string
    {
        $dDate = Carbon::now();
        $dayCount = $dDate->diffInDays(Carbon::parse($dateTime));
        if ($dDate->lessThan(Carbon::parse($dateTime))) {
            $dayCount *= -1;
        }
        if ($dayCount < self::vert->value) return 'Dans le délai';
        else if ($dayCount < self::jaune->value) return 'Acceptable';
        else if ($dayCount < self::rouge->value) return 'Inquiétant';
        else return 'Dangereux';

    }
}
