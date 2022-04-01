<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;  

class ChannelResource extends JsonResource
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
                'id'            => $this->id,
                'name'          => $this->name, 
                'channelActive' => $this->channel_active,
                'image'         => $this->image,
                'userID'        => $this->user_id,
                'channelUuid'   => $this->uuid,
                'createdAt'     => $this->created_at,
                'updatedAt'     => $this->updated_at,
                'profile'       => $this->profile,
                'posts'         => ForumpostostResource::collection($this->whenLoaded('posts')), 

        ];
    }
} 







 