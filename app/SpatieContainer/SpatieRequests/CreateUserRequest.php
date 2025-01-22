<?php

namespace App\SpatieContainer\SpatieRequests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;
use Illuminate\Validation\Rules;

class CreateUserRequest extends FormRequest
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
            'name' => 'required|string|max:255',
            'email' => 'bail|required|string|lowercase|email|max:255|' . Rule::unique('users', 'email'),
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'status' => 'sometimes|array',
            'roles' => 'sometimes|array',
            'permissions' => 'sometimes|array'
        ];
    }
}
