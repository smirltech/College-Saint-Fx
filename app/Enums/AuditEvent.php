<?php

namespace App\Enums;

enum AuditEvent: string
{
    case created = 'created';
    case retrieved = 'retrieved';
    case updated = 'updated';
    case deleted = 'deleted';
    case restored = 'restored';
    case forceDeleted = 'force_deleted';

    case loggedIn = 'logged_in';
    case loggedOut = 'logged_out';

    public function variant(): string
    {
        return match ($this) {
            AuditEvent::created => 'success',
            AuditEvent::retrieved => 'primary',
            AuditEvent::updated => 'warning',
            AuditEvent::deleted => 'danger',
            AuditEvent::restored => 'success',
            AuditEvent::forceDeleted => 'danger',
            AuditEvent::loggedIn => 'info',
            AuditEvent::loggedOut => 'warning',
        };
    }

    public function label(): string
    {
        // match the enum value with the label, using match expression
        return match ($this) {
            AuditEvent::created => 'Créé',
            AuditEvent::retrieved => 'Récupéré',
            AuditEvent::updated => 'Modifié',
            AuditEvent::deleted => 'Supprimé',
            AuditEvent::restored => 'Restauré',
            AuditEvent::forceDeleted => 'Supprimé définitivement',
            AuditEvent::loggedIn => 'Connecté',
            AuditEvent::loggedOut => 'Déconnecté',

        };
    }

}
