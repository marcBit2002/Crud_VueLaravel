<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class CursResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'sigles' => $this->sigles,
            'nom' => $this->nom,
            'actiu' => $this->actiu,
            'cicle_id' => $this->cicle->id,
            'cicle' => $this->cicle->nom,
        ];
    }
}
