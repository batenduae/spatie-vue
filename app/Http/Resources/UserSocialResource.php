<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserSocialResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        return [
            'user_id' => $this->user_id,
            'userName' => $this->user()->name,
            'facebook' => $this->facebook,
            'instagram' => $this->instagram,
            'x_twitter' => $this->x_twitter,
            'whatsapp' => $this->whatsapp,
            'linkedIn' => $this->linkedIn,
            'youtube' => $this->youtube,
            'website' => $this->website,
        ];
    }
}
