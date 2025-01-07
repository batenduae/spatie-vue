<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserProfileResource extends JsonResource
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
            'imagePath' => $this->imagePath,
            'formalPhoto' => $this->formalPhoto,
            'religion' => $this->religion,
            'gender' => $this->gender,
            'birthDay' => $this->birthDay,
            'bloodGroup' => $this->bloodGroup,
            'primaryPhone' => $this->primaryPhone,
            'secondaryPhone' => $this->secondaryPhone,
        ];
    }
}
