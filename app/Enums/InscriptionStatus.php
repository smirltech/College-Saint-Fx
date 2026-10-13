<?php

namespace App\Enums;

enum InscriptionStatus: string
{
    case pending = 'pending';
    case approved = 'approved';
    case rejected = 'rejected';
    case canceled = 'canceled';

    // label() is a method that returns the label of the enum
    public function variant(): string
    {
        return match ($this) {
            InscriptionStatus::pending => "info",
            InscriptionStatus::approved => "success",
            InscriptionStatus::rejected => "danger",
            InscriptionStatus::canceled => "secondary",
            default => "default",
        };
    }


    // label() is a method that returns the label of the enum

    public function label($sexe = Sexe::M): string
    {
        if ($sexe == Sexe::M) return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvé',
            self::rejected => 'Rejeté',
            self::canceled => 'Annulé',
        };
        else return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvée',
            self::rejected => 'Rejetée',
            self::canceled => 'Annulée',
        };
    }

    public function pluralLabel($sexe = Sexe::M): string
    {
        if ($sexe == Sexe::M) return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvés',
            self::rejected => 'Rejetés',
            self::canceled => 'Annulés',
        };
        else return match ($this) {
            self::pending => 'En attente',
            self::approved => 'Approuvées',
            self::rejected => 'Rejetées',
            self::canceled => 'Annulées',
        };
    }

}
