<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreCreateInscription extends FormRequest
{
    /**
     * @return array<string, mixed>
     */
    public function rules(): array
    {
        return [
            'annee' => ['required', 'string', 'max:255'],
            'fiche' => ['required', 'file', 'mimes:xlsx,xls'],
        ];
    }
}
