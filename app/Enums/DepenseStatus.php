<?php

namespace App\Enums;

enum DepenseStatus: string
{
    case pending = 'pending';
    case approved_coordonnateur = 'approved_coordonnateur';
    case rejected_coordonnateur = 'rejected_coordonnateur';
    case approved_promoteur = 'approved_promoteur';
    case rejected_promoteur = 'rejected_promoteur';
    case canceled = 'canceled';
    case issued = 'issued';
    case done = 'done';

    public function label(): string
    {
        return match ($this) {
            self::pending => 'En attente',
            self::approved_coordonnateur => 'Approuvé par le coordonnateur',
            self::rejected_coordonnateur => 'Rejeté par le coordonnateur',
            self::approved_promoteur => 'Approuvé par le promoteur',
            self::rejected_promoteur => 'Rejeté par le promoteur',
            self::canceled => 'Annulé',
            self::issued => 'Payé',
            self::done => 'Terminé',
            default => 'Inconnu',
        };
    }

    public function color(): string
    {
        return match ($this) {
            self::pending => 'info',
            self::approved_coordonnateur, self::approved_promoteur => 'success',
            self::rejected_coordonnateur, self::rejected_promoteur => 'danger',
            self::canceled => 'warning',
            self::issued => 'primary',
            self::done => 'secondary',
            default => 'default',
        };
    }

    /**
     * Get the roles that can change the status.
     */
    public function roles(): ?array
    {
        return match ($this) {
            self::pending, self::rejected_coordonnateur => [UserRole::coordonnateur->value, UserRole::admin->value],
            self::approved_coordonnateur, self::rejected_promoteur => [UserRole::promoteur->value, UserRole::admin->value],
            default => null,
        };
    }


}
