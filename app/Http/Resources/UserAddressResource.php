<?php

namespace App\Http\Resources;

use App\Models\User;
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
            'id' => $this->id,
            'user_id' => $this->user_id,
            'user_name' => User::findOrFail($this->user_id)->name,
            'user_email' => User::findOrFail($this->user_id)->email,
            'addressType' => $this->addressType,
            'district' => $this->district,
            'typeVillageMunicipalityCity' => $this->typeVillageMunicipalityCity,
            'upazillaCity' => $this->upazillaCity,
            'policeStation' => $this->policeStation,
            'unionMunicipality' => $this->unionMunicipality,
            'wardCouncil' => $this->wardCouncil,
            'villageMohokuma' => $this->villageMohokuma,
            'roadNo' => $this->roadNo,
            'houseNo' => $this->houseNo,
            'otherDetails' => $this->otherDetails,
        ];
    }
}
