<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserAddressResource extends JsonResource
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
            'addressType' => $this->addressType,
            'district' => $this->district,
            'typeVillageMunicipalityCity' => $this->typeVillageMunicipalityCity,
            'upazillaCity' => $this->upazillaCity,
            'unionMunicipality' => $this->unionMunicipality,
            'wardCouncil' => $this->wardCouncil,
            'villageMohokuma' => $this->villageMohokuma,
            'roadNo' => $this->roadNo,
            'houseNo' => $this->houseNo,
            'otherDetails' => $this->otherDetails,
        ];
    }
}
