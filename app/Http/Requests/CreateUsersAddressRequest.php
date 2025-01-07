<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;

class CreateUsersAddressRequest extends FormRequest
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
            'user_id' => 'required',
            'addressType' => 'required|string|max:255',
            'district' => 'required|string|max:255',
            'typeVillageMunicipalityCity' => 'required|string|max:255',
            'upazillaCity' => 'required|string|max:255',
            'policeStation' => 'required|string|max:255',
            'unionMunicipality' => 'required|string|max:255',
            'wardCouncil' => 'required|string|max:255',
            'villageMohokuma' => 'required|string|max:255',
            'roadNo' => 'sometimes|string|max:255',
            'houseNo' => 'sometimes|string|max:255',
            'otherDetails' => 'sometimes|string|max:255',
        ];
    }
}
