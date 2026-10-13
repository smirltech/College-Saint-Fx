<?php

namespace App\Enums;

enum DemandeStatus: string
{
    case pending = 'pending';
    case accepted = 'accepted';
    case rejected = 'rejected';
    case available = 'available';
    case unavailable = 'unavailable';
    case invalid = 'invalid';

    /**
     * @return string
     */
    public function label(): string
    {
        // match the enum value with the label, using match expression
        return match ($this) {
            DemandeStatus::pending => 'En attente',
            DemandeStatus::accepted => 'Acceptée',
            DemandeStatus::rejected => 'Rejetée',
            DemandeStatus::available => 'Disponible',
            DemandeStatus::unavailable => 'Non disponible',
            DemandeStatus::invalid => 'Invalide',

        };
    }


    /**
     * @return string
     */
    public function action(): string
    {
        // match the enum value with the label, using match expression
        return match ($this) {
            DemandeStatus::pending => 'Mettre en attente',
            DemandeStatus::accepted => 'Accepter',
            DemandeStatus::rejected => 'Rejeter',
            DemandeStatus::available => 'Rendre disponible',
            DemandeStatus::unavailable => 'Rendre indisponible',
            DemandeStatus::invalid => 'Invalider',
        };

    }

    public function variant(): string
    {
        return match ($this) {
            DemandeStatus::pending => 'info',
            DemandeStatus::accepted => 'success',
            DemandeStatus::rejected => 'danger',
            DemandeStatus::available => 'primary',
            DemandeStatus::unavailable => 'warning',
            DemandeStatus::invalid => 'danger',
        };
    }

    public function message(): string
    {
        return match ($this) {
            DemandeStatus::pending => 'Demande est en attente de validation',
            DemandeStatus::accepted => 'La demande a été traitée avec succès',
            DemandeStatus::rejected => 'La demande a été rejetée',
            DemandeStatus::available => 'Les données de l\'étudiant sont disponibles',
            DemandeStatus::unavailable => 'Aucun relevé disponible',
            DemandeStatus::invalid => 'Le numero matricule est invalide',
        };
    }

    public function isAccepted(): bool
    {
        return $this === DemandeStatus::accepted;
    }

    public function isAvailable(): bool
    {
        return $this === DemandeStatus::available;
    }

    // is pending
    public function isPending(): bool
    {
        return $this == DemandeStatus::pending;
    }

    // is rejected
    public function isRejected(): bool
    {
        return $this == DemandeStatus::rejected;
    }

    // is unavailable
    public function isUnavailable(): bool
    {
        return $this == DemandeStatus::unavailable;
    }
}
