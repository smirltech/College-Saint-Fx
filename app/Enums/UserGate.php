<?php

namespace App\Enums;

enum UserGate
{

    // -------------------  ELEVES  ------------------- //
    case browse_eleves;
    case create_eleves;
    // -------------------  ./ELEVES  ------------------- //
    // -------------------  RESPONSABLES  ------------------- //
    case browse_responsables;
    // -------------------  ./RESPONSABLES  ------------------- //
    // -------------------  INSCRIPTIONS  ------------------- //
    case browse_inscriptions;
    // -------------------  ./INSCRIPTIONS  ------------------- //

    case browse_settings;
    case browse_users;
    case browse_roles;
    case browse_permissions;

    case browse_enseignants;
    case browse_devoirs;
    case browse_factures;

    case browse_calendar;
    case browse_finance;
    case browse_logistique;
    case browse_bibliotheque;

    case browse_programme;

    case browse_classes;

    case browse_cours;

    public function roles(): array
    {
        return match ($this) {
            self::browse_eleves => [
                UserRole::promoteur->value,
                //UserRole::parent->value,
            ],
            self::create_eleves => [
                UserRole::promoteur->value,
            ],
            self::browse_responsables => [

                UserRole::admin->value,
            ],
            self::browse_finance => [
                UserRole::promoteur->value,
                UserRole::financier->value,
            ],
            self::browse_settings => [
                UserRole::promoteur->value,
            ],
            self::browse_users => [
                UserRole::promoteur->value,
                UserRole::admin->value,
            ],
            self::browse_roles => [
                UserRole::promoteur->value,
                UserRole::admin->value,
            ],
            self::browse_permissions => [
                UserRole::promoteur->value,
                UserRole::admin->value,
            ],
            self::browse_enseignants => [
                UserRole::promoteur->value,
                UserRole::admin->value,
            ],
            self::browse_devoirs => [
                UserRole::promoteur->value,
                UserRole::enseignant->value,
                UserRole::eleve->value,
                UserRole::parent->value,

            ],
            self::browse_factures => [
                UserRole::promoteur->value,
                UserRole::admin->value,
                UserRole::financier->value,
            ],
            self::browse_inscriptions => [
                // UserRole::promoteur->value,
                UserRole::admin->value,
            ],
            self::browse_logistique => [
                UserRole::promoteur->value,
                UserRole::admin->value,
            ],

            self::browse_bibliotheque => [
                UserRole::promoteur->value,
                UserRole::admin->value,
                UserRole::enseignant->value,
                UserRole::eleve->value,

            ],
            self::browse_calendar => [
                UserRole::promoteur->value,
                UserRole::admin->value,
                UserRole::enseignant->value,
                UserRole::eleve->value,
                UserRole::parent->value,
            ],

            self::browse_programme => [
                UserRole::promoteur->value,
                UserRole::admin->value,
                UserRole::enseignant->value,

            ],

            self::browse_classes => [
                UserRole::promoteur->value,
                UserRole::admin->value,
                UserRole::enseignant->value,
            ],

            self::browse_cours => [
                UserRole::promoteur->value,
                UserRole::admin->value,
                UserRole::enseignant->value,
                UserRole::eleve->value,
                UserRole::parent->value,
            ],


        };
    }


}
