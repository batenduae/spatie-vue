<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class UsersAddressRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'user_id' => 'required|exists:users,id',
            'addressType' => 'required|string|max:60',
            'district' => 'required|string|max:60',
            'typeVillageMunicipalityCity' => 'required|string|max:100',
            'upazillaCity' => 'required|string|max:100',
            'policeStation' => 'required|string|max:100',
            'unionMunicipality' => 'required|string|max:100',
            'wardCouncil' => 'required|string|max:100',
            'villageMohokuma' => 'required|string|max:100',
            'roadNo' => 'sometimes|string|max:50',
            'houseNo' => 'sometimes|string|max:50',
            'otherDetails' => 'sometimes',
        ];
    }
}
