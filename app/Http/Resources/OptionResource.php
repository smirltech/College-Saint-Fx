<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class OptionResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'code' => $this->code,
            'section_id' => $this->section_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'classes' => ClasseResource::collection($this->whenLoaded('classes')),
            'filieres' => FiliereResource::collection($this->whenLoaded('filieres')),
        ];
    }
}
