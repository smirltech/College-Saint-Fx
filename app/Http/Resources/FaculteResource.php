<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class FaculteResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     *
  "id": 1,
  "nom": "Theologie",
  "code": "TH",
  "email": "theo@upl-univ.ac",
  "filieres": [

  ],
  "created_at": "2022-07-30T20:19:57.000000Z",
  "updated_at": "2022-07-30T20:19:57.000000Z"
}
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'nom' => $this->nom,
            'code' => $this->code,
            'email' => $this->email,
            'filieres' => $this->filieres,
            'admins' => $this->admins,
            'admin_emails' => $this->admin_emails,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}