<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserEducationalBackgroundResource extends JsonResource
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
            'degree' => $this->degree,
            'institution' => $this->institution,
            'session' => $this->session,
            'dept_group' => $this->dept_group,
            'passingYear' => $this->passingYear,
            'result' => $this->result,
        ];
    }
}
