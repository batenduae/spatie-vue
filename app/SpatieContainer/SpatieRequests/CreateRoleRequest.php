<?php

namespace App\SpatieContainer\SpatieRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class CreateRoleRequest extends FormRequest
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
            'name' => ['required', 'max:30', 'string', Rule::unique('roles', 'name')->ignore($this->role)],
            'group' => ['sometimes', 'nullable', 'max:100', 'string'],
            'description' => ['sometimes', 'nullable', 'max:100', 'string'],
            'permissions' => ['sometimes', 'nullable', 'array'],

        ];
    }
}
