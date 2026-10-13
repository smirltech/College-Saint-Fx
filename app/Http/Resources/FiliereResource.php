<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FiliereResource extends JsonResource
{
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'code' => $this->code,
            'option_id' => $this->option_id,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'classes' => ClasseResource::collection($this->whenLoaded('classes')),
        ];
    }
}
