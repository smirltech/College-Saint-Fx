<?php

namespace App\Enums;

enum MediaType: string
{
    case bordereaux = 'bordereaux';
    case diplome = 'diplome';
    case fiche_inscription = 'fiche_inscription';
    case piece_identite = 'piece_identite';
    case photo_passport = 'photo_passport';

    case avatar = 'avatar';

    case bulletin = 'bulletin';
    case document = 'document';

    //folder() is a method that returns the folder name
    public function folder(): string
    {
        return match ($this) {
            self::bordereaux => 'bordereaux',
            self::diplome => 'diplomes',
            self::fiche_inscription => 'fiches',
            self::piece_identite => 'pieces',
            self::photo_passport => 'photos',
            self::bulletin => 'bulletins',
            self::document => 'documents',
            self::avatar => 'avatars',
        };
    }

    //label() is a method that returns the label of the enum
    public function label(): string
    {
        return match ($this) {
            self::bordereaux => 'Bordereau',
            self::diplome => 'Diplome',
            self::fiche_inscription => 'Fiche d\'inscription',
            self::piece_identite => 'Piece d\'identite',
            self::photo_passport => 'Photo de passport',
            self::bulletin => 'Bulletin',
            self::document => 'Devoir',
            self::avatar => 'Avatar',

        };
    }

}
