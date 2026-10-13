<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class InscriptionResource extends JsonResource
{

    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'eleve' => EleveResource::make($this->eleve),
            'classe' => ClasseResource::make($this->whenLoaded('classe')),
            'annee' => AnneeResource::make($this->annee),
            'categorie' => $this->categorie,
            'montant' => $this->montant,
            'status' => $this->status,
            'code' => $this->code,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,

        ];
    }
}
