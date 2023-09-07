<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class ProfileResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request): array
{
    $data = [
        'id' => $this->id,
        'name' => $this->name,
        'email' => $this->email,
    ];

    if ($this->relationLoaded('followers')) {
        $data['followerCount'] = count($this->followers);
    }

    if ($this->relationLoaded('followings')) {
        $data['followingCount'] = count($this->followings);
    }
    
    return $data;
}

}
