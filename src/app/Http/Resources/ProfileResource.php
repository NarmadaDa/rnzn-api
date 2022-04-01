<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;  
use App\Http\Resources\UserResource; 
use App\Models\User;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $uuid   = User::select('uuid')->where('id', $this->user_id)->first();

        return [  
                'firstName'     => $this->first_name,
                'middleName'    => $this->middle_name, 
                'lastName'      => $this->last_name,
                'image'         => $this->image, 
                'userUuid'      => $uuid->uuid  
        ];
    }
}