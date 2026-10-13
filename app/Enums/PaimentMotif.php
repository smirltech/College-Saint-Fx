<?php

namespace App\Enums;

enum PaimentMotif: string
{
    case salaire = 'salaire';
    case avance_salaire = 'avance_salaire';
    case prime = 'prime';
    case autre = 'autre';

}
