<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class ArticalResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [ 
            'uuid' => $this->uuid,
            'title' => $this->title,
            'updated_at' => $this->updated_at, 
            'shortlist_order' => $this->shortlist_order,
            'roles' => $this->roles,
        ];
    }
}
